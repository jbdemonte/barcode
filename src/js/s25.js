function computeS25(value){
  var sum = 0,
    odd = true;
  for(i=value.length-1; i>-1; i--){
    sum += (odd ? 3 : 1) * parseInt(value.charAt(i));
    odd = ! odd;
  }
  return (10 - sum % 10) % 10;
}
$(function(){
  $("#s25Message")
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
      if (filtered.length > 0){
        $("#s25Checksum").html( computeS25(filtered) );
      } else {
        $("#s25Checksum").html("");
      }
    });

  $("#s25Target").barcode("87654321", "std25");

  $("#s25generator")
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
      if (filtered.length > 0){
        $("#s25Target").barcode(filtered, "std25");
      } else {
        $("#s25Target").html("");
      }
    });
});