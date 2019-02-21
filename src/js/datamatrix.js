$(function(){
  $("#datamatrixTarget").barcode("1234567", "datamatrix");

  $("#datamatrixGenerator")
    .keyup(function(){
      var $this = $(this),
        text = $this.val(),
        filtered = "",
        c = '';
      for(var i=0; i<text.length; i++){
        c = text.charAt(i);
        filtered += c;
      }
      $this.val(filtered);
      $("#datamatrixTarget").barcode(filtered, "datamatrix");
    });
});