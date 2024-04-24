$(".img_post").click(function () {
    window.open($(this).attr("src"), 'popUpWindow', "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
});