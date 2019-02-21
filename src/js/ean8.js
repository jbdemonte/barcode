function computeEAN8(value){
  var sum = 0,
    odd = true;
  for(i=6; i>-1; i--){
    sum += (odd ? 3 : 1) * parseInt(value.charAt(i));
    odd = ! odd;
  }
  return (10 - sum % 10) % 10;
}
$(function(){
  $("#ean8Message")
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
      if (filtered.length == 7){
        $("#ean8Checksum").html( computeEAN8(filtered) );
      } else {
        $("#ean8Checksum").html("");
      }
    });

  $("#ean8Target").barcode("12345670", "ean8");

  $("#ean8generator")
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
      if (filtered.length >= 7){
        $("#ean8Target").barcode(filtered, "ean8");
      } else {
        $("#ean8Target").html("");
      }
    });
});