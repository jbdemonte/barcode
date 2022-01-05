/*!
 *  BarCode Coder Library (BCC Library)
 *  BCCL Version 2.0
 *
 *  Porting : jQuery barcode plugin
 *  Version : 2.2
 *
 *  Date    : 2019-02-21
 *  Author  : DEMONTE Jean-Baptiste <jbdemonte@gmail.com>
 *            HOUREZ Jonathan
 *
 *  Web site: http://barcode-coder.com/
 *  dual licence :  http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html
 *                  http://www.gnu.org/licenses/gpl.html
 */

(function ($) {

  var defaultSettings = {
      barWidth: 1,
      barHeight: 50,
      moduleSize: 5,
      showHRI: true,
      addQuietZone: true,
      marginHRI: 5,
      bgColor: "#FFFFFF",
      color: "#000000",
      fontSize: 10,
      output: "css",
      posX: 0,
      posY: 0
    };

  // * * * * * * * * * * * * * * * * * * * * * *
  // std25 int25
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingI25 = ["NNWWN", "WNNNW", "NWNNW", "WWNNN", "NNWNW", "WNWNN", "NWWNN", "NNNWW", "WNNWN", "NWNWN"];

  function computeI25(code, crc, type) {
    var i, v,
      odd = true,
      sum = 0;
    if (!crc) {
      if (code.length % 2 !== 0) {
        code = "0" + code;
      }
    } else {
      if (type === "int25" && code.length % 2 === 0) {
        code = "0" + code;
      }
      for (i = code.length - 1; i > -1; i--) {
        v = intval(code.charAt(i));
        if (isNaN(v)) {
          return "";
        }
        sum += odd ? 3 * v : v;
        odd = !odd;
      }
      code += ((10 - sum % 10) % 10).toString();
    }
    return code;
  }

  function getDigitI25(code, crc, type) {
    var i, j, c1, c2, c, result = "";
    code = computeI25(code, crc, type);
    if (type === "int25") {
      // Interleaved 2 of 5

      // start
      result += "1010";

      // digits + CRC
      for (i = 0; i < code.length / 2; i++) {
        c1 = code.charAt(2 * i);
        c2 = code.charAt(2 * i + 1);
        for (j = 0; j < 5; j++) {
          result += "1";
          if (encodingI25[c1].charAt(j) === 'W') {
            result += "1";
          }
          result += "0";
          if (encodingI25[c2].charAt(j) === 'W') {
            result += "0";
          }
        }
      }
      // stop
      result += "1101";
    } else if (type === "std25") {
      // Standard 2 of 5 is a numeric-only barcode that has been in use a long time.
      // Unlike Interleaved 2 of 5, all of the information is encoded in the bars; the spaces are fixed width and are used only to separate the bars.
      // The code is self-checking and does not include a checksum.

      // start
      result += "11011010";

      // digits + CRC
      for (i = 0; i < code.length; i++) {
        c = code.charAt(i);
        for (j = 0; j < 5; j++) {
          result += "1";
          if (encodingI25[c].charAt(j) === 'W') {
            result += "11";
          }
          result += "0";
        }
      }
      // stop
      result += "11010110";
    }
    return result;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // ean
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingEAN = [ ["0001101", "0100111", "1110010"],
    ["0011001", "0110011", "1100110"],
    ["0010011", "0011011", "1101100"],
    ["0111101", "0100001", "1000010"],
    ["0100011", "0011101", "1011100"],
    ["0110001", "0111001", "1001110"],
    ["0101111", "0000101", "1010000"],
    ["0111011", "0010001", "1000100"],
    ["0110111", "0001001", "1001000"],
    ["0001011", "0010111", "1110100"] ],
    firstEAN =  ["000000", "001011", "001101", "001110", "010011", "011001", "011100", "010101", "010110", "011010"],
    encodingEAN_addon2 = ["00", "01", "10", "11"],
    encodingEAN_addon5 = ["11000", "10100", "10010", "10001", "01100", "00110", "00011", "01010", "01001", "00101"];

  function getDigitEAN(code, type) {
    // Check len (12 for ean13, 7 for ean8)
    var i, x, y, addon, checksum, result, seq, part_of_addon, a_or_b, partialencoding, odd,
      len = type === "ean8" ? 7 : 12,
      fullcode = code;
    code = code.substring(0, len);

    if (!code.match(new RegExp("^[0-9]{" + len + "}$"))) {
      return "";
    }
    // get checksum
    code = computeEAN(code, type);

    // process analyse
    result = "101"; // start

    if (type === "ean8") {

      // process left part
      for (i = 0; i < 4; i++) {
        result += encodingEAN[intval(code.charAt(i))][0];
      }

      // center guard bars
      result += "01010";

      // process right part
      for (i = 4; i < 8; i++) {
        result += encodingEAN[intval(code.charAt(i))][2];
      }

    } else { // ean13
      // extract first digit and get sequence
      seq = firstEAN[intval(code.charAt(0))];

      // process left part
      for (i = 1; i < 7; i++) {
        result += encodingEAN[intval(code.charAt(i))][intval(seq.charAt(i - 1))];
      }

      // center guard bars
      result += "01010";

      // process right part
      for (i = 7; i < 13; i++) {
        result += encodingEAN[intval(code.charAt(i))][2];
      }
    } // ean13

    result += "101"; // stop

    // addon 13+2 / 13+5
    if (type === "ean13") {
      addon = fullcode.substring(13, fullcode.length);

      if (addon.length === 2) {
        result += "0000000000";
        // checksum addon
        checksum = parseInt(addon, 10) % 4;
        // binary encoding
        for (i = 0; i < 2; i++) {
          part_of_addon = intval(addon.charAt(i));
          a_or_b = intval(encodingEAN_addon2[intval(checksum)][i]);
          partialencoding = encodingEAN[part_of_addon][a_or_b];
          result += partialencoding;
        }
      } else if (addon.length === 5) {
        result += "0000000000";
        // checksum addon
        odd = true;
        x = y = 0;
        for (i = 0; i < 5; i++) {
          if (!odd) {
            x += intval(addon.charAt(i));
          } else {
            y += intval(addon.charAt(i));
          }
          odd = !odd;
        }
        checksum = ((9 * x) + (3 * y)) % 10;
        // binary encoding
        result += "1011"; // special delimiter

        for (i = 0; i < 5; i++) {
          part_of_addon = intval(addon.charAt(i));
          a_or_b = intval(encodingEAN_addon5[intval(checksum)][i]);
          partialencoding = encodingEAN[part_of_addon][a_or_b];
          result += partialencoding;

          // 01 separator
          if (i < 4) {
            result += "01";
          }
        }
      }
    }
    return result;
  }
  function computeEAN(code, type) {
    var i,
      len = type === "ean13" ? 12 : 7,
      addon = code.substring(13, code.length),
      sum = 0,
      odd = true;
    code = code.substring(0, len);
    for (i = code.length - 1; i > -1; i--) {
      sum += (odd ? 3 : 1) * intval(code.charAt(i));
      odd = !odd;
    }
    return code + ((10 - sum % 10) % 10).toString() + (addon ? " " + addon : "");
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // upc
  // * * * * * * * * * * * * * * * * * * * * * *

  function getDigitUPC(code) {
    if (code.length < 12) {
      code = "0" + code;
    }
    return getDigitEAN(code, "ean13");
  }

  function computeUPC(code) {
    if (code.length < 12) {
      code = "0" + code;
    }
    return computeEAN(code, "ean13").substr(1);
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // code 11
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingCode11 = [ "101011", "1101011", "1001011", "1100101",
    "1011011", "1101101", "1001101", "1010011",
    "1101001", "110101", "101101"];

  function getDigitCode11(code) {
    var c, k, i, index, weightC, weightSumC, weightK, weightSumK,
      table = "0123456789-",
      intercharacter = "0",
      // start
      result = "1011001" + intercharacter;

    // digits
    for (i = 0; i < code.length; i++) {
      index = table.indexOf(code.charAt(i));
      if (index < 0) {
        return "";
      }
      result += encodingCode11[index] + intercharacter;
    }

    // checksum
    weightC    = 0;
    weightSumC = 0;
    weightK    = 1; // start at 1 because the right-most character is "C" checksum
    weightSumK = 0;

    for (i = code.length - 1; i >= 0; i--) {
      weightC = weightC === 10 ? 1 : weightC + 1;
      weightK = weightK === 10 ? 1 : weightK + 1;

      index = table.indexOf(code.charAt(i));

      weightSumC += weightC * index;
      weightSumK += weightK * index;
    }

    c = weightSumC % 11;
    weightSumK += c;
    k = weightSumK % 11;

    result += encodingCode11[c] + intercharacter;

    if (code.length >= 10) {
      result += encodingCode11[k] + intercharacter;
    }

    // stop
    result  += "1011001";

    return result;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // code 39
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingCode39 = ["101001101101", "110100101011", "101100101011", "110110010101",
    "101001101011", "110100110101", "101100110101", "101001011011",
    "110100101101", "101100101101", "110101001011", "101101001011",
    "110110100101", "101011001011", "110101100101", "101101100101",
    "101010011011", "110101001101", "101101001101", "101011001101",
    "110101010011", "101101010011", "110110101001", "101011010011",
    "110101101001", "101101101001", "101010110011", "110101011001",
    "101101011001", "101011011001", "110010101011", "100110101011",
    "110011010101", "100101101011", "110010110101", "100110110101",
    "100101011011", "110010101101", "100110101101", "100100100101",
    "100100101001", "100101001001", "101001001001", "100101101101"];

  function getDigitCode39(code) {
    var i, index,
      result = "",
      table = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%*",
      intercharacter = "0";

    if (code.indexOf("*") >= 0) {
      return "";
    }

    // Add Start and Stop charactere : *
    code = ("*" + code + "*").toUpperCase();

    for (i = 0; i < code.length; i++) {
      index = table.indexOf(code.charAt(i));
      if (index < 0) {
        return "";
      }
      if (i > 0) {
        result += intercharacter;
      }
      result += encodingCode39[index];
    }
    return result;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // code 93
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingCode93 = ["100010100", "101001000", "101000100", "101000010",
    "100101000", "100100100", "100100010", "101010000",
    "100010010", "100001010", "110101000", "110100100",
    "110100010", "110010100", "110010010", "110001010",
    "101101000", "101100100", "101100010", "100110100",
    "100011010", "101011000", "101001100", "101000110",
    "100101100", "100010110", "110110100", "110110010",
    "110101100", "110100110", "110010110", "110011010",
    "101101100", "101100110", "100110110", "100111010",
    "100101110", "111010100", "111010010", "111001010",
    "101101110", "101110110", "110101110", "100100110",
    "111011010", "111010110", "100110010", "101011110"];

  function getDigitCode93(code, crc) {
    var c, k, i, index, weightC, weightSumC, weightK, weightSumK,
      table = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%____*", // _ => ($), (%), (/) et (+)
      result = "";

    if (code.indexOf('*') >= 0) {
      return "";
    }

    code = code.toUpperCase();

    // start :  *
    result  += encodingCode93[47];

    // digits
    for (i = 0; i < code.length; i++) {
      c = code.charAt(i);
      index = table.indexOf(c);
      if ((c === '_') || (index < 0)) {
        return "";
      }
      result += encodingCode93[index];
    }

    // checksum
    if (crc) {
      weightC    = 0;
      weightSumC = 0;
      weightK    = 1; // start at 1 because the right-most character is "C" checksum
      weightSumK = 0;
      for (i = code.length - 1; i >= 0; i--) {
        weightC = weightC === 20 ? 1 : weightC + 1;
        weightK = weightK === 15 ? 1 : weightK + 1;

        index = table.indexOf(code.charAt(i));

        weightSumC += weightC * index;
        weightSumK += weightK * index;
      }

      c = weightSumC % 47;
      weightSumK += c;
      k = weightSumK % 47;

      result += encodingCode93[c];
      result += encodingCode93[k];
    }

    // stop : *
    result  += encodingCode93[47];

    // Terminaison bar
    result  += "1";
    return result;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // code 128
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingCode128 = ["11011001100", "11001101100", "11001100110", "10010011000",
    "10010001100", "10001001100", "10011001000", "10011000100",
    "10001100100", "11001001000", "11001000100", "11000100100",
    "10110011100", "10011011100", "10011001110", "10111001100",
    "10011101100", "10011100110", "11001110010", "11001011100",
    "11001001110", "11011100100", "11001110100", "11101101110",
    "11101001100", "11100101100", "11100100110", "11101100100",
    "11100110100", "11100110010", "11011011000", "11011000110",
    "11000110110", "10100011000", "10001011000", "10001000110",
    "10110001000", "10001101000", "10001100010", "11010001000",
    "11000101000", "11000100010", "10110111000", "10110001110",
    "10001101110", "10111011000", "10111000110", "10001110110",
    "11101110110", "11010001110", "11000101110", "11011101000",
    "11011100010", "11011101110", "11101011000", "11101000110",
    "11100010110", "11101101000", "11101100010", "11100011010",
    "11101111010", "11001000010", "11110001010", "10100110000",
    "10100001100", "10010110000", "10010000110", "10000101100",
    "10000100110", "10110010000", "10110000100", "10011010000",
    "10011000010", "10000110100", "10000110010", "11000010010",
    "11001010000", "11110111010", "11000010100", "10001111010",
    "10100111100", "10010111100", "10010011110", "10111100100",
    "10011110100", "10011110010", "11110100100", "11110010100",
    "11110010010", "11011011110", "11011110110", "11110110110",
    "10101111000", "10100011110", "10001011110", "10111101000",
    "10111100010", "11110101000", "11110100010", "10111011110",
    "10111101110", "11101011110", "11110101110", "11010000100",
    "11010010000", "11010011100", "11000111010"];

    function getDigitCode128(code) {
      var i, c, tableCActivated, result, sum,
        tableB = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~",
        isum = 0,
        j = 0,
        value = 0;

      // check each characters
      for (i = 0; i < code.length; i++) {
        if (tableB.indexOf(code.charAt(i)) === -1) {
          return "";
        }
      }

      // check firsts characters : start with C table only if enough numeric
      tableCActivated = code.length > 1;
      for (i = 0; i < 3 && i < code.length; i++) {
        c = code.charAt(i);
        tableCActivated = tableCActivated && c >= '0' && c <= '9';
      }


      sum = tableCActivated ? 105 : 104;

      // start : [105] : C table or [104] : B table
      result = encodingCode128[sum];

      i = 0;
      while (i < code.length) {
        if (!tableCActivated) {
          j = 0;
          // check next character to activate C table if interresting
          while ((i + j < code.length) && (code.charAt(i + j) >= '0') && (code.charAt(i + j) <= '9')) {
            j++;
          }

          // 6 min everywhere or 4 mini at the end
          tableCActivated = (j > 5) || ((i + j - 1 === code.length) && (j > 3));

          if (tableCActivated) {
            result += encodingCode128[99]; // C table
            sum += ++isum * 99;
          }
          //         2 min for table C so need table B
        } else if ((i === code.length) || (code.charAt(i) < '0') || (code.charAt(i) > '9') || (code.charAt(i + 1) < '0') || (code.charAt(i + 1) > '9')) {
          tableCActivated = false;
          result += encodingCode128[100]; // B table
          sum += ++isum * 100;
        }

        if (tableCActivated) {
          value = intval(code.charAt(i) + code.charAt(i + 1)); // Add two characters (numeric)
          i += 2;
        } else {
          value = tableB.indexOf(code.charAt(i)); // Add one character
          i += 1;
        }
        result  += encodingCode128[value];
        sum += ++isum * value;
      }

      // Add CRC
      result  += encodingCode128[sum % 103];

      // Stop
      result += encodingCode128[106];

      // Termination bar
      result += "11";

      return result;
    }

  // * * * * * * * * * * * * * * * * * * * * * *
  // codabar
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingCodabar = ["101010011", "101011001", "101001011", "110010101",
    "101101001", "110101001", "100101011", "100101101",
    "100110101", "110100101", "101001101", "101100101",
    "1101011011", "1101101011", "1101101101", "1011011011",
    "1011001001", "1010010011", "1001001011", "1010011001"];

  function getDigitCodabar(code) {
    var i, index, result,
      intercharacter = "0",
      table = "0123456789-$:/.+";

    // add start : A->D : arbitrary choose A
    result = encodingCodabar[16] + intercharacter;

    for (i = 0; i < code.length; i++) {
      index = table.indexOf(code.charAt(i));
      if (index < 0) {
        return "";
      }
      result += encodingCodabar[index] + intercharacter;
    }

    // add stop : A->D : arbitrary choose A
    result += encodingCodabar[16];
    return result;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // msi
  // * * * * * * * * * * * * * * * * * * * * * *

  var encodingMsi = ["100100100100", "100100100110", "100100110100", "100100110110",
    "100110100100", "100110100110", "100110110100", "100110110110",
    "110100100100", "110100100110"];

  function computeMsi(code, crc) {
    if (typeof crc === "object") {
      if (crc.crc1 === "mod10") {
        code = computeMod10Msi(code);
      } else if (crc.crc1 === "mod11") {
        code = computeMod11Msi(code);
      }
      if (crc.crc2 === "mod10") {
        code = computeMod10Msi(code);
      } else if (crc.crc2 === "mod11") {
        code = computeMod11Msi(code);
      }
    } else if (typeof crc === "boolean" && crc) {
      code = computeMod10Msi(code);
    }
    return code;
  }

  function computeMod10Msi(code) {
    var i, s1,
      toPart1 = code.length % 2,
      n1 = 0,
      sum = 0;
    for (i = 0; i < code.length; i++) {
      if (toPart1) {
        n1 = 10 * n1 + intval(code.charAt(i));
      } else {
        sum += intval(code.charAt(i));
      }
      toPart1 = !toPart1;
    }
    s1 = (2 * n1).toString();
    for (i = 0; i < s1.length; i++) {
      sum += intval(s1.charAt(i));
    }
    return code + ((10 - sum % 10) % 10).toString();
  }

  function computeMod11Msi(code) {
    var i, sum = 0, weight = 2;
    for (i = code.length - 1; i >= 0; i--) {
      sum += weight * intval(code.charAt(i));
      weight = weight === 7 ? 2 : weight + 1;
    }
    return code + ((11 - sum % 11) % 11).toString();
  }

  function getDigitMsi(code) {
    var i,
      table = "0123456789",
      index = 0,
      result = "110"; // start

    code = computeMsi(code, false);

    // digits
    for (i = 0; i < code.length; i++) {
      index = table.indexOf(code.charAt(i));
      if (index < 0) {
        return "";
      }
      result += encodingMsi[index];
    }

    // stop
    result += "1001";

    return result;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // datamatrix
  // * * * * * * * * * * * * * * * * * * * * * *

  var getDigitDatamatrix = (function () {
    var lengthRows = [ 10, 12, 14, 16, 18, 20, 22, 24, 26,  // 24 squares et 6 rectangular
        32, 36, 40, 44, 48, 52, 64, 72, 80,  88, 96, 104, 120, 132, 144,
        8, 8, 12, 12, 16, 16],
      lengthCols = [ 10, 12, 14, 16, 18, 20, 22, 24, 26,  // Number of columns for the entire datamatrix
        32, 36, 40, 44, 48, 52, 64, 72, 80, 88, 96, 104, 120, 132, 144,
        18, 32, 26, 36, 36, 48],
      dataCWCount = [ 3, 5, 8, 12,  18,  22,  30,  36,  // Number of data codewords for the datamatrix
        44, 62, 86, 114, 144, 174, 204, 280, 368, 456, 576, 696, 816, 1050,
        1304, 1558, 5, 10, 16, 22, 32, 49],
      solomonCWCount = [ 5, 7, 10, 12, 14, 18, 20, 24, 28, // Number of Reed-Solomon codewords for the datamatrix
        36, 42, 48, 56, 68, 84, 112, 144, 192, 224, 272, 336, 408, 496, 620,
        7, 11, 14, 18, 24, 28],
      dataRegionRows = [ 8, 10, 12, 14, 16, 18, 20, 22, // Number of rows per region
        24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22,
        6,  6, 10, 10, 14, 14],
      dataRegionCols = [ 8, 10, 12, 14, 16, 18, 20, 22, // Number of columns per region
        24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22,
        16, 14, 24, 16, 16, 22],
      regionRows = [ 1, 1, 1, 1, 1, 1, 1, 1, // Number of regions per row
        1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6,
        1, 1, 1, 1, 1, 1],
      regionCols = [ 1, 1, 1, 1, 1, 1, 1, 1, // Number of regions per column
        1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6,
        1, 2, 1, 2, 2, 2],
      interleavedBlocks = [1, 1, 1, 1, 1, 1, 1, 1, // Number of blocks
        1, 1, 1, 1, 1, 1, 2, 2, 4, 4, 4, 4, 6, 6, 8, 8,
        1, 1, 1, 1, 1, 1],
      logTab = [ -255, 255, 1, 240, 2, 225, 241, 53, 3,  // Table of log for the Galois field
        38, 226, 133, 242, 43, 54, 210, 4, 195, 39, 114, 227, 106, 134, 28,
        243, 140, 44, 23, 55, 118, 211, 234, 5, 219, 196, 96, 40, 222, 115,
        103, 228, 78, 107, 125, 135, 8, 29, 162, 244, 186, 141, 180, 45, 99,
        24, 49, 56, 13, 119, 153, 212, 199, 235, 91, 6, 76, 220, 217, 197,
        11, 97, 184, 41, 36, 223, 253, 116, 138, 104, 193, 229, 86, 79, 171,
        108, 165, 126, 145, 136, 34, 9, 74, 30, 32, 163, 84, 245, 173, 187,
        204, 142, 81, 181, 190, 46, 88, 100, 159, 25, 231, 50, 207, 57, 147,
        14, 67, 120, 128, 154, 248, 213, 167, 200, 63, 236, 110, 92, 176, 7,
        161, 77, 124, 221, 102, 218, 95, 198, 90, 12, 152, 98, 48, 185, 179,
        42, 209, 37, 132, 224, 52, 254, 239, 117, 233, 139, 22, 105, 27, 194,
        113, 230, 206, 87, 158, 80, 189, 172, 203, 109, 175, 166, 62, 127,
        247, 146, 66, 137, 192, 35, 252, 10, 183, 75, 216, 31, 83, 33, 73,
        164, 144, 85, 170, 246, 65, 174, 61, 188, 202, 205, 157, 143, 169, 82,
        72, 182, 215, 191, 251, 47, 178, 89, 151, 101, 94, 160, 123, 26, 112,
        232, 21, 51, 238, 208, 131, 58, 69, 148, 18, 15, 16, 68, 17, 121, 149,
        129, 19, 155, 59, 249, 70, 214, 250, 168, 71, 201, 156, 64, 60, 237,
        130, 111, 20, 93, 122, 177, 150],
      aLogTab = [ 1, 2, 4, 8, 16, 32, 64, 128, 45, 90, // Table of aLog for the Galois field
        180, 69, 138, 57, 114, 228, 229, 231, 227, 235, 251, 219, 155, 27, 54,
        108, 216, 157, 23, 46, 92, 184, 93, 186, 89, 178, 73, 146, 9, 18, 36,
        72, 144, 13, 26, 52, 104, 208, 141, 55, 110, 220, 149, 7, 14, 28, 56,
        112, 224, 237, 247, 195, 171, 123, 246, 193, 175, 115, 230, 225, 239,
        243, 203, 187, 91, 182, 65, 130, 41, 82, 164, 101, 202, 185, 95, 190,
        81, 162, 105, 210, 137, 63, 126, 252, 213, 135, 35, 70, 140, 53, 106,
        212, 133, 39, 78, 156, 21, 42, 84, 168, 125, 250, 217, 159, 19, 38, 76,
        152, 29, 58, 116, 232, 253, 215, 131, 43, 86, 172, 117, 234, 249, 223,
        147, 11, 22, 44, 88, 176, 77, 154, 25, 50, 100, 200, 189, 87, 174, 113,
        226, 233, 255, 211, 139, 59, 118, 236, 245, 199, 163, 107, 214, 129,
        47, 94, 188, 85, 170, 121, 242, 201, 191, 83, 166, 97, 194, 169, 127,
        254, 209, 143, 51, 102, 204, 181, 71, 142, 49, 98, 196, 165, 103, 206,
        177, 79, 158, 17, 34, 68, 136, 61, 122, 244, 197, 167, 99, 198, 161,
        111, 222, 145, 15, 30, 60, 120, 240, 205, 183, 67, 134, 33, 66, 132,
        37, 74, 148, 5, 10, 20, 40, 80, 160, 109, 218, 153, 31, 62, 124, 248,
        221, 151, 3, 6, 12, 24, 48, 96, 192, 173, 119, 238, 241, 207, 179, 75,
        150, 1];

    function champGaloisMult(a, b) {  // MULTIPLICATION IN GALOIS FIELD GF(2^8)
      if (!a || !b) {
        return 0;
      }
      return aLogTab[(logTab[a] + logTab[b]) % 255];
    }

    function champGaloisDoub(a, b) {  // THE OPERATION a * 2^b IN GALOIS FIELD GF(2^8)
      if (!a) {
        return 0;
      }
      if (!b) {
        return a;
      }
      return aLogTab[(logTab[a] + b) % 255];
    }

    function champGaloisSum(a, b) { // SUM IN GALOIS FIELD GF(2^8)
      return a ^ b;
    }

    function selectIndex(dataCodeWordsCount, rectangular) { // CHOOSE THE GOOD INDEX FOR TABLES
      var n = 0;
      if ((dataCodeWordsCount < 1 || dataCodeWordsCount > 1558) && !rectangular) {
        return -1;
      }
      if ((dataCodeWordsCount < 1 || dataCodeWordsCount > 49) && rectangular) {
        return -1;
      }
      if (rectangular) {
        n = 24;
      }

      while (dataCWCount[n] < dataCodeWordsCount) {
        n++;
      }
      return n;
    }

    function encodeDataCodeWordsASCII(text) {
      var i, c,
        dataCodeWords = [],
        n = 0;
      for (i = 0; i < text.length; i++) {
        c = text.charCodeAt(i);
        if (c > 127) {
          dataCodeWords[n] = 235;
          c = c - 127;
          n++;
        } else if ((c >= 48 && c <= 57) && (i + 1 < text.length) && (text.charCodeAt(i + 1) >= 48 && text.charCodeAt(i + 1) <= 57)) {
          c = ((c - 48) * 10) + ((text.charCodeAt(i + 1)) - 48);
          c += 130;
          i++;
        } else {
          c++;
        }
        dataCodeWords[n] = c;
        n++;
      }
      return dataCodeWords;
    }

    function addPadCW(tab, from, to) {
      var r, i;
      if (from >= to) {
        return;
      }
      tab[from] = 129;
      for (i = from + 1; i < to; i++) {
        r = ((149 * (i + 1)) % 253) + 1;
        tab[i] = (129 + r) % 254;
      }
    }

    function calculSolFactorTable(aSolomonCWCount) { // CALCULATE THE REED SOLOMON FACTORS
      var i, j,
        g = [];

      for (i = 0; i <= aSolomonCWCount; i++) {
        g[i] = 1;
      }

      for (i = 1; i <= aSolomonCWCount; i++) {
        for (j = i - 1; j >= 0; j--) {
          g[j] = champGaloisDoub(g[j], i);
          if (j > 0) {
            g[j] = champGaloisSum(g[j], g[j - 1]);
          }
        }
      }
      return g;
    }

    function addReedSolomonCW(nSolomonCW, coeffTab, nDataCW, dataTab, blocks) { // Add the Reed Solomon codewords
      var i, j, k,
        temp = 0,
        errorBlocks = nSolomonCW / blocks,
        correctionCW = [];
      for (k = 0; k < blocks; k++) {
        for (i = 0; i < errorBlocks; i++) {
          correctionCW[i] = 0;
        }

        for (i = k; i < nDataCW; i += blocks) {
          temp = champGaloisSum(dataTab[i], correctionCW[errorBlocks - 1]);
          for (j = errorBlocks - 1; j >= 0; j--) {

            correctionCW[j] = temp ? champGaloisMult(temp, coeffTab[j]) : 0;
            if (j > 0) {
              correctionCW[j] = champGaloisSum(correctionCW[j - 1], correctionCW[j]);
            }
          }
        }
        // Renversement des blocs calcules
        j = nDataCW + k;
        for (i = errorBlocks - 1; i >= 0; i--) {
          dataTab[j] = correctionCW[i];
          j += blocks;
        }
      }
      return dataTab;
    }

    function getBits(entier) { // Transform integer to tab of bits
      var i,
        bits = [];
      for (i = 0; i < 8; i++) {
        bits[i] = entier & (128 >> i) ? 1 : 0;
      }
      return bits;
    }

    function next(etape, totalRows, totalCols, codeWordsBits, datamatrix, assigned) { // Place codewords into the matrix
      var chr = 0, // Place of the 8st bit from the first character to [4][0]
        row = 4,
        col = 0;

      do {
        // Check for a special case of corner
        if ((row === totalRows) && !col) {
          patternShapeSpecial1(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
          chr++;
        } else if ((etape < 3) && (row === totalRows - 2) && !col && (totalCols % 4)) {
          patternShapeSpecial2(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
          chr++;
        } else if ((row === totalRows - 2) && !col && (totalCols % 8 === 4)) {
          patternShapeSpecial3(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
          chr++;
        } else if ((row === totalRows + 4) && (col === 2) && (totalCols % 8 === 0)) {
          patternShapeSpecial4(datamatrix, assigned, codeWordsBits[chr], totalRows, totalCols);
          chr++;
        }

        // Go up and right in the datamatrix
        do {
          if ((row < totalRows) && (col >= 0) && (assigned[row][col] !== 1)) {
            patternShapeStandard(datamatrix, assigned, codeWordsBits[chr], row, col, totalRows, totalCols);
            chr++;
          }
          row -= 2;
          col += 2;
        } while ((row >= 0) && (col < totalCols));
        row += 1;
        col += 3;

        // Go down and left in the datamatrix
        do {
          if ((row >= 0) && (col < totalCols) && (assigned[row][col] !== 1)) {
            patternShapeStandard(datamatrix, assigned, codeWordsBits[chr], row, col, totalRows, totalCols);
            chr++;
          }
          row += 2;
          col -= 2;
        } while ((row < totalRows) && (col >= 0));
        row += 3;
        col += 1;
      } while ((row < totalRows) || (col < totalCols));
    }

    function patternShapeStandard(datamatrix, assigned, bits, row, col, totalRows, totalCols) { // Place bits in the matrix (standard or special case)
      var f = placeBitInDatamatrix;
      f(datamatrix, assigned, bits[0], row - 2, col - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[1], row - 2, col - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[2], row - 1, col - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[3], row - 1, col - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[4], row - 1, col, totalRows, totalCols);
      f(datamatrix, assigned, bits[5], row, col - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[6], row, col - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[7], row,  col, totalRows, totalCols);
    }

    function patternShapeSpecial1(datamatrix, assigned, bits, totalRows, totalCols) {
      var f = placeBitInDatamatrix;
      f(datamatrix, assigned, bits[0], totalRows - 1,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[1], totalRows - 1,  1, totalRows, totalCols);
      f(datamatrix, assigned, bits[2], totalRows - 1,  2, totalRows, totalCols);
      f(datamatrix, assigned, bits[3], 0, totalCols - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[4], 0, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[5], 1, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[6], 2, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[7], 3, totalCols - 1, totalRows, totalCols);
    }

    function patternShapeSpecial2(datamatrix, assigned, bits, totalRows, totalCols) {
      var f = placeBitInDatamatrix;
      f(datamatrix, assigned, bits[0], totalRows - 3,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[1], totalRows - 2,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[2], totalRows - 1,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[3], 0, totalCols - 4, totalRows, totalCols);
      f(datamatrix, assigned, bits[4], 0, totalCols - 3, totalRows, totalCols);
      f(datamatrix, assigned, bits[5], 0, totalCols - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[6], 0, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[7], 1, totalCols - 1, totalRows, totalCols);
    }

    function patternShapeSpecial3(datamatrix, assigned, bits, totalRows, totalCols) {
      var f = placeBitInDatamatrix;
      f(datamatrix, assigned, bits[0], totalRows - 3,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[1], totalRows - 2,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[2], totalRows - 1,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[3], 0, totalCols - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[4], 0, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[5], 1, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[6], 2, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[7], 3, totalCols - 1, totalRows, totalCols);
    }

    function patternShapeSpecial4(datamatrix, assigned, bits, totalRows, totalCols) {
      var f = placeBitInDatamatrix;
      f(datamatrix, assigned, bits[0], totalRows - 1,  0, totalRows, totalCols);
      f(datamatrix, assigned, bits[1], totalRows - 1, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[2], 0, totalCols - 3, totalRows, totalCols);
      f(datamatrix, assigned, bits[3], 0, totalCols - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[4], 0, totalCols - 1, totalRows, totalCols);
      f(datamatrix, assigned, bits[5], 1, totalCols - 3, totalRows, totalCols);
      f(datamatrix, assigned, bits[6], 1, totalCols - 2, totalRows, totalCols);
      f(datamatrix, assigned, bits[7], 1, totalCols - 1, totalRows, totalCols);
    }

    function placeBitInDatamatrix(datamatrix, assigned, bit, row, col, totalRows, totalCols) { // Put a bit into the matrix
      if (row < 0) {
        row += totalRows;
        col += 4 - ((totalRows + 4) % 8);
      }
      if (col < 0) {
        col += totalCols;
        row += 4 - ((totalCols + 4) % 8);
      }
      if (assigned[row][col] !== 1) {
        datamatrix[row][col] = bit;
        assigned[row][col] = 1;
      }
    }

    function addFinderPattern(datamatrix, rowsRegion, colsRegion, rowsRegionCW, colsRegionCW) { // Add the finder pattern
      var i, j,
        totalRowsCW = (rowsRegionCW + 2) * rowsRegion,
        totalColsCW = (colsRegionCW + 2) * colsRegion,
        datamatrixTemp = [];
      datamatrixTemp[0] = [];
      for (j = 0; j < totalColsCW + 2; j++) {
        datamatrixTemp[0][j] = 0;
      }
      for (i = 0; i < totalRowsCW; i++) {
        datamatrixTemp[i + 1] = [];
        datamatrixTemp[i + 1][0] = 0;
        datamatrixTemp[i + 1][totalColsCW + 1] = 0;
        for (j = 0; j < totalColsCW; j++) {
          if (i % (rowsRegionCW + 2) === 0) {
            if (j % 2) {
              datamatrixTemp[i + 1][j + 1] = 0;
            } else {
              datamatrixTemp[i + 1][j + 1] = 1;
            }
          } else if (i % (rowsRegionCW + 2) === rowsRegionCW + 1) {
            datamatrixTemp[i + 1][j + 1] = 1;
          } else if (j % (colsRegionCW + 2) === colsRegionCW + 1) {
            if (i % 2) {
              datamatrixTemp[i + 1][j + 1] = 1;
            } else {
              datamatrixTemp[i + 1][j + 1] = 0;
            }
          } else if (j % (colsRegionCW + 2) === 0) {
            datamatrixTemp[i + 1][j + 1] = 1;
          } else {
            datamatrixTemp[i + 1][j + 1] = 0;
            datamatrixTemp[i + 1][j + 1] = datamatrix[i - 1 - (2 * (parseInt(i / (rowsRegionCW + 2), 10)))][j - 1 - (2 * (parseInt(j / (colsRegionCW + 2), 10)))];
          }
        }
      }
      datamatrixTemp[totalRowsCW + 1] = [];
      for (j = 0; j < totalColsCW + 2; j++) {
        datamatrixTemp[totalRowsCW + 1][j] = 0;
      }
      return datamatrixTemp;
    }

    return function (text, rectangular) {
      var i, g,
        dataCodeWords = encodeDataCodeWordsASCII(text), // Code the text in the ASCII mode
        aDataCWCount = dataCodeWords.length,
        index = selectIndex(aDataCWCount, rectangular), // Select the index for the data tables
        totalDataCWCount = dataCWCount[index], // Number of data CW
        aSolomonCWCount = solomonCWCount[index], // Number of Reed Solomon CW
        totalCWCount = totalDataCWCount + aSolomonCWCount, // Number of CW
        rowsTotal = lengthRows[index], // Size of symbol
        colsTotal = lengthCols[index],
        rowsRegion = regionRows[index], // Number of region
        colsRegion = regionCols[index],
        rowsRegionCW = dataRegionRows[index],
        colsRegionCW = dataRegionCols[index],
        rowsLengthMatrice = rowsTotal - 2 * rowsRegion, // Size of matrice data
        colsLengthMatrice = colsTotal - 2 * colsRegion,
        blocks = interleavedBlocks[index],  // Number of Reed Solomon blocks
        errorBlocks = (aSolomonCWCount / blocks),
        codeWordsBits = [], // Calculte bits from codewords
        datamatrix = [], // Put data in the matrix
        assigned = [];

      addPadCW(dataCodeWords, aDataCWCount, totalDataCWCount); // Add codewords pads

      g = calculSolFactorTable(errorBlocks); // Calculate correction coefficients

      addReedSolomonCW(aSolomonCWCount, g, totalDataCWCount, dataCodeWords, blocks); // Add Reed Solomon codewords

      for (i = 0; i < totalCWCount; i++) {
        codeWordsBits[i] = getBits(dataCodeWords[i]);
      }

      for (i = 0; i < colsLengthMatrice; i++) {
        datamatrix[i] = [];
        assigned[i] = [];
      }

      // Add the bottom-right corner if needed
      if (((rowsLengthMatrice * colsLengthMatrice) % 8) === 4) {
        datamatrix[rowsLengthMatrice - 2][colsLengthMatrice - 2] = 1;
        datamatrix[rowsLengthMatrice - 1][colsLengthMatrice - 1] = 1;
        datamatrix[rowsLengthMatrice - 1][colsLengthMatrice - 2] = 0;
        datamatrix[rowsLengthMatrice - 2][colsLengthMatrice - 1] = 0;
        assigned[rowsLengthMatrice - 2][colsLengthMatrice - 2] = 1;
        assigned[rowsLengthMatrice - 1][colsLengthMatrice - 1] = 1;
        assigned[rowsLengthMatrice - 1][colsLengthMatrice - 2] = 1;
        assigned[rowsLengthMatrice - 2][colsLengthMatrice - 1] = 1;
      }

      // Put the codewords into the matrix
      next(0, rowsLengthMatrice, colsLengthMatrice, codeWordsBits, datamatrix, assigned);

      // Add the finder pattern
      datamatrix = addFinderPattern(datamatrix, rowsRegion, colsRegion, rowsRegionCW, colsRegionCW);

      return datamatrix;
    }
  })();

  // * * * * * * * * * * * * * * * * * * * * * *
  // tools
  // * * * * * * * * * * * * * * * * * * * * * *

  function intval(val) {
    var type = typeof val;
    if (type === "string") {
      val = val.replace(/[^0-9-.]/g, "");
      val = parseInt(val * 1, 10);
      return isNaN(val) || !isFinite(val) ? 0 : val;
    }
    return type === "number" && isFinite(val) ? Math.floor(val) : 0;
  }

  // lec tools - (little endian convertor tools)
  // convert an int
  function lecCInt(value, byteCount) {
    var i,
      le = "";
    for (i = 0; i < byteCount; i++) {
      le += String.fromCharCode(value & 0xFF);
      value = value >> 8;
    }
    return le;
  }

  // return a byte string from rgb values
  function lecCRgb(r, g, b) {
    return String.fromCharCode(b) + String.fromCharCode(g) + String.fromCharCode(r);
  }

  // return a byte string from a hex string color
  function lecCHexColor(hex) {
    var g, r,
      v = parseInt("0x" + hex.substr(1), 16),
      b = v & 0xFF;
    v = v >> 8;
    g = v & 0xFF;
    r = v >> 8;
    return (lecCRgb(r, g, b));
  }

  function hexToRGB(hex) {
    var g, r,
      v = parseInt("0x" + hex.substr(1), 16),
      b = v & 0xFF;
    v = v >> 8;
    g = v & 0xFF;
    r = v >> 8;
    return ({r: r, g: g, b: b});
  }

  // test if a string is a hexa string color (like #FF0000)
  function isHexColor(value) {
    return value.match(/#[0-91-F]/gi);
  }

  // encode data in base64
  function base64Encode(value) {
    var c1, c2, c3, b1, b2, b3, b4,
      r = '',
      k = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
      i = 0;
    while (i < value.length) {
      c1 = value.charCodeAt(i++);
      c2 = value.charCodeAt(i++);
      c3 = value.charCodeAt(i++);
      b1 = c1 >> 2;
      b2 = ((c1 & 3) << 4) | (c2 >> 4);
      b3 = ((c2 & 15) << 2) | (c3 >> 6);
      b4 = c3 & 63;
      if (isNaN(c2)) {
        b3 = b4 = 64;
      } else if (isNaN(c3)) {
        b4 = 64;
      }
      r += k.charAt(b1) + k.charAt(b2) + k.charAt(b3) + k.charAt(b4);
    }
    return r;
  }

  // convert a bit string to an array of array of bit char
  function bitStringTo2DArray(digit) {
    var i,
      d = [];
    d[0] = [];
    for (i = 0; i < digit.length; i++) {
      d[0][i] = parseInt(digit.charAt(i), 10);
    }
    return d;
  }

  // clear jQuery Target
  function resize($container, w) {
    $container
      .css("padding", "0")
      .css("overflow", "auto")
      .css("width", w + "px")
      .html("");
    return $container;
  }

  // apply antialiasing for CSS rendering only
  function antialiasing($container){
    $container
      .css("display", "flex")
      .css("flex-flow", "row wrap")
      .css("justify-content", "space-around");
    return $container;
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // Raw Renderer functions
  // * * * * * * * * * * * * * * * * * * * * * *

  // bmp barcode renderer
  function digitToBmpRenderer($container, settings, digit, hri, mw, mh) {
    var i, y, x, k, padding, dataLen, bmp, line, object,
      lines = digit.length,
      columns = digit[0].length,
      c0 = isHexColor(settings.bgColor) ? lecCHexColor(settings.bgColor) : lecCRgb(255, 255, 255),
      c1 = isHexColor(settings.color) ? lecCHexColor(settings.color) : lecCRgb(0, 0, 0),
      bar0 = "",
      bar1 = "",
      pad = "";

    // create one bar 0 and 1 of "mw" byte length
    for (i = 0; i < mw; i++) {
      bar0 += c0;
      bar1 += c1;
    }

    padding = (4 - ((mw * columns * 3) % 4)) % 4; // Padding for 4 byte alignment ("* 3" come from "3 byte to color R, G and B")
    dataLen = ((mw * columns * 3) + padding) * mh * lines;

    for (i = 0; i < padding; i++) {
      pad += '\0';
    }

    // Bitmap header
    bmp = 'BM' +                        // Magic Number
      lecCInt(54 + dataLen, 4) +  // Size of Bitmap size (header size + data len)
      '\0\0\0\0' +                      // Unused
      lecCInt(54, 4) +            // The offset where the bitmap data (pixels) can be found
      lecCInt(40, 4) +            // The number of bytes in the header (from this point).
      lecCInt(mw * columns, 4) +  // width
      lecCInt(mh * lines, 4) +    // height
      lecCInt(1, 2) +             // Number of color planes being used
      lecCInt(24, 2) +            // The number of bits/pixel
      '\0\0\0\0' +                      // BI_RGB, No compression used
      lecCInt(dataLen, 4) +       // The size of the raw BMP data (after this header)
      lecCInt(2835, 4) +          // The horizontal resolution of the image (pixels/meter)
      lecCInt(2835, 4) +          // The vertical resolution of the image (pixels/meter)
      lecCInt(0, 4) +             // Number of colors in the palette
      lecCInt(0, 4);              // Means all colors are important
    // Bitmap Data
    for (y = lines - 1; y >= 0; y--) {
      line = "";
      for (x = 0; x < columns; x++) {
        line += digit[y][x] ? bar1 : bar0;
      }
      line += pad;
      for (k = 0; k < mh; k++) {
        bmp += line;
      }
    }
    // set bmp image to the container
    object = document.createElement("object");
    object.setAttribute("type", "image/bmp");
    object.setAttribute("data", "data:image/bmp;base64," + base64Encode(bmp));
    resize($container, mw * columns + padding).append(object);
  }

  // css barcode renderer
  function digitToCssRenderer($container, settings, digit, hri, mw, mh) {
    var x, y, len, current,
      lines = digit.length,
      columns = digit[0].length,
      content = "",
      bar0 = "<div style=\"float: left; font-size: 0; background-color: " + settings.bgColor + "; height: " + mh + "px; width: &Wpx\"></div>",
      bar1 = "<div style=\"float: left; font-size: 0; width:0; border-left: &Wpx solid " + settings.color + "; height: " + mh + "px;\"></div>";
    for (y = 0; y < lines; y++) {
      len = 0;
      current = digit[y][0];
      for (x = 0; x < columns; x++) {
        if (current === digit[y][x]) {
          len++;
        } else {
          content += (current ? bar1 : bar0).replace("&W", len * mw);
          current = digit[y][x];
          len = 1;
        }
      }
      if (len > 0) {
        content += (current ? bar1 : bar0).replace("&W", len * mw);
      }
    }
    if (settings.showHRI) {
      content += "<div style=\"clear:both; width: 100%; background-color: " + settings.bgColor + "; color: " + settings.color + "; text-align: center; font-size: " + settings.fontSize + "px; margin-top: " + settings.marginHRI + "px;\">" + hri + "</div>";
    }
    antialiasing($container);
    resize($container, mw * columns).html(content);
  }

  // svg barcode renderer
  function digitToSvgRenderer($container, settings, digit, hri, mw, mh) {
    var x, y, fontSize, svg, bar1, len, current, object,
      lines = digit.length,
      columns = digit[0].length,
      width = mw * columns,
      height = mh * lines;

    if (settings.showHRI) {
      fontSize = intval(settings.fontSize);
      height += intval(settings.marginHRI) + fontSize;
    }

    // svg header
    svg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="' + width + '" height="' + height + '" shape-rendering="crispEdges">';

    // background
    svg += '<rect width="' +  width + '" height="' + height + '" x="0" y="0" fill="' + settings.bgColor + '" />';

    bar1 = '<rect width="&W" height="' + mh + '" x="&X" y="&Y" fill="' + settings.color + '" />';

    for (y = 0; y < lines; y++) {
      len = 0;
      current = digit[y][0];
      for (x = 0; x < columns; x++) {
        if (current === digit[y][x]) {
          len++;
        } else {
          if (current) {
            svg += bar1.replace("&W", len * mw).replace("&X", (x - len) * mw).replace("&Y", y * mh);
          }
          current = digit[y][x];
          len = 1;
        }
      }
      if (len && current) {
        svg += bar1.replace("&W", len * mw).replace("&X", (columns - len) * mw).replace("&Y", y * mh);
      }
    }

    if (settings.showHRI) {
      svg += '<g transform="translate(' + Math.floor(width / 2) + ' 0)">';
      svg += '<text y="' + (height - Math.floor(fontSize / 2)) + '" text-anchor="middle" style="font-family: Arial; font-size: ' + fontSize + 'px;" fill="' + settings.color + '">' + hri + '</text>';
      svg += '</g>';
    }
    // svg footer
    svg += '</svg>';

    // create a dom object, flush container and add object to the container

    object = document.createElement('img');
    object.setAttribute('src', 'data:image/svg+xml;base64,'+ base64Encode(svg));
    resize($container, width).append(object);
  }

  // canvas barcode renderer
  function digitToCanvasRenderer($container, settings, digit, hri, xi, yi, mw, mh) {
    var x, y, ctx, len, current, dim,
      canvas = $container.get(0),
      lines = digit.length,
      columns = digit[0].length;

    if (!canvas || !canvas.getContext) {
      return; // not compatible
    }

    ctx = canvas.getContext("2d");
    ctx.lineWidth = 1;
    ctx.lineCap = "butt";
    ctx.fillStyle = settings.bgColor;
    ctx.fillRect(xi, yi, columns * mw, lines * mh);

    ctx.fillStyle = settings.color;

    for (y = 0; y < lines; y++) {
      len = 0;
      current = digit[y][0];
      for (x = 0; x < columns; x++) {
        if (current === digit[y][x]) {
          len++;
        } else {
          if (current) {
            ctx.fillRect(xi + (x - len) * mw, yi + y * mh, mw * len, mh);
          }
          current = digit[y][x];
          len = 1;
        }
      }
      if (len && current) {
        ctx.fillRect(xi + (columns - len) * mw, yi + y * mh, mw * len, mh);
      }
    }
    if (settings.showHRI) {
      dim = ctx.measureText(hri);
      ctx.fillText(hri, xi + Math.floor((columns * mw - dim.width) / 2), yi + lines * mh + settings.fontSize + settings.marginHRI);
    }
  }

  // * * * * * * * * * * * * * * * * * * * * * *
  // Renderer
  // * * * * * * * * * * * * * * * * * * * * * *

  var renderer = {};

  // bmp 1D barcode renderer
  renderer.bmp = function ($container, settings, digit, hri) {
    var w = intval(settings.barWidth),
      h = intval(settings.barHeight);
    digitToBmpRenderer($container, settings, bitStringTo2DArray(digit), hri, w, h);
  };

  // bmp 2D barcode renderer
  renderer.bmp2 = function ($container, settings, digit, hri) {
    var s = intval(settings.moduleSize);
    digitToBmpRenderer($container, settings, digit, hri, s, s);
  };

  // css 1D barcode renderer
  renderer.css = function ($container, settings, digit, hri) {
    var w = intval(settings.barWidth),
      h = intval(settings.barHeight);
    digitToCssRenderer($container, settings, bitStringTo2DArray(digit), hri, w, h);
  };

  // css 2D barcode renderer
  renderer.css2 = function ($container, settings, digit, hri) {
    var s = intval(settings.moduleSize);
    digitToCssRenderer($container, settings, digit, hri, s, s);
  };

  // svg 1D barcode renderer
  renderer.svg = function ($container, settings, digit, hri) {
    var w = intval(settings.barWidth),
      h = intval(settings.barHeight);
    digitToSvgRenderer($container, settings, bitStringTo2DArray(digit), hri, w, h);
  };

  // svg 2D barcode renderer
  renderer.svg2 = function ($container, settings, digit, hri) {
    var s = intval(settings.moduleSize);
    digitToSvgRenderer($container, settings, digit, hri, s, s);
  };

  // canvas 1D barcode renderer
  renderer.canvas = function ($container, settings, digit, hri) {
    var w  = intval(settings.barWidth),
      h = intval(settings.barHeight),
      x = intval(settings.posX),
      y = intval(settings.posY);
    digitToCanvasRenderer($container, settings, bitStringTo2DArray(digit), hri, x, y, w, h);
  };

  // canvas 2D barcode renderer
  renderer.canvas2 = function ($container, settings, digit, hri) {
    var s = intval(settings.moduleSize),
      x = intval(settings.posX),
      y = intval(settings.posY);
    digitToCanvasRenderer($container, settings, digit, hri, x, y, s, s);
  };

  $.fn.barcode = function (data, type, settings) {
    var code, crc, rect, fn,
      digit = "",
      hri   = "",
      b2d   = false;

    data = $.extend({crc: true, rect: false}, typeof data === "object" ? data : {code: data});

    code  = data.code;
    crc   = data.crc;
    rect  = data.rect;

    if (code) {
      settings = $.extend(true, defaultSettings, settings);

      switch (type) {
      case "std25":
      case "int25":
        digit = getDigitI25(code, crc, type);
        hri = getDigitI25(code, crc, type);
        break;
      case "ean8":
      case "ean13":
        digit = getDigitEAN(code, type);
        hri = computeEAN(code, type);
        break;
      case "upc":
        digit = getDigitUPC(code);
        hri = computeUPC(code);
        break;
      case "code11":
        digit = getDigitCode11(code);
        hri = code;
        break;
      case "code39":
        digit = getDigitCode39(code);
        hri = code;
        break;
      case "code93":
        digit = getDigitCode93(code, crc);
        hri = code;
        break;
      case "code128":
        digit = getDigitCode128(code);
        hri = code;
        break;
      case "codabar":
        digit = getDigitCodabar(code);
        hri = code;
        break;
      case "msi":
        digit = getDigitMsi(code);
        hri = computeMsi(code, crc);
        break;
      case "datamatrix":
        digit = getDigitDatamatrix(code, rect);
        hri = code;
        b2d = true;
        break;
      }
      if (digit.length) {
        // Quiet Zone
        if (!b2d && settings.addQuietZone) {
          digit = "0000000000" + digit + "0000000000";
        }

        fn = renderer[settings.output + (b2d ? '2' : '')];
        if (fn) {
          this.each(function () {
            fn($(this), settings, digit, hri);
          });
        }
      }
    }
    return this;
  };

}(jQuery));
