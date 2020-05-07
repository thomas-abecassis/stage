//code pris sur stackOverflow
var scroll_start = 0;
var startchange = $('#anchor');
var offset = startchange.offset();
 if (startchange.length){
$(document).scroll(function() {
   scroll_start = $(this).scrollTop();
   if(scroll_start > offset.top) {
 document.getElementById('sticky').classList.add('sticky-top');
    } else {
 document.getElementById('sticky').classList.remove('sticky-top');
    }
});
}
