var menuTimer = [];
var menuLocked = [];

function menuHideAndLockYoyo($this){
  var id = $this.attr("id");
  menuLocked[id] = true;
  clearTimeout(menuTimer[id]);
  $(".menu-item-block", $this).slideUp("fast", function(){setTimeout("menuLocked['"+$(this).parent().attr("id")+"'] = false;", 20);});
}

$(function(){
  $(".menu-item").each(function(){
    menuLocked[$(this).attr("id")] = false;
    $(this).hover(
      function(){
        var $this = $(this);
        var id = $this.attr("id");
        if ( menuLocked[id] ) return;
        $(".menu-item-block", $this).slideDown("fast");
        menuTimer[id] = setTimeout("menuHideAndLockYoyo($(\"#" + id + "\"));", 15000);
      },
      function(){
        menuHideAndLockYoyo($(this));
      }
    );
  });

  $(".menu-item-block-item")
    .click(function(){ window.location.href = $("a", $(this)).attr("href"); })
    .hover(function(){$(this).addClass("hover");}, function(){$(this).removeClass("hover");});
});