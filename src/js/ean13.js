function computeEAN13(value){
  var sum = 0,
    odd = true;
  for(i=11; i>-1; i--){
    sum += (odd ? 3 : 1) * parseInt(value.charAt(i));
    odd = ! odd;
  }
  return (10 - sum % 10) % 10;
}

$(function() {
  $("#ean13Message")
    .keyup(function(){
      var $this = $(this),
        text = $this.val(),
        filtered = "",
        c = '';
      for(var i=0; i<text.length; i++){
        c = text.charAt(i);
        if ( (c >= '0') && (c <= '9') ){
          filtered += c;
        }
      }
      $this.val(filtered);
      if (filtered.length == 12){
        $("#ean13Checksum").html( computeEAN13(filtered) );
      } else {
        $("#ean13Checksum").html("");
      }
    });

  $("#ean13Target").barcode("2109876543210", "ean13");

  $("#ean13generator")
    .keyup(function(){
      var $this = $(this),
        text = $this.val(),
        filtered = "",
        c = '';
      for(var i=0; i<text.length; i++){
        c = text.charAt(i);
        if ( (c >= '0') && (c <= '9') ){
          filtered += c;
        }
      }
      $this.val(filtered);
      if (filtered.length >= 12){
        $("#ean13Target").barcode(filtered, "ean13");
      } else {
        $("#ean13Target").html("");
      }
    });
});