//code pris sur stackOverflow
let vw;
var scroll_start = 0;
var startchange = $('#anchor');
var offset = startchange.offset();
if (startchange.length){
	$(document).scroll(function() {
		vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
			if(vw > 1100){
		   	scroll_start = $(this).scrollTop();
		   	if(scroll_start > offset.top) {
			 document.getElementById('sticky').classList.add('sticky-top');
			} else {
			 document.getElementById('sticky').classList.remove('sticky-top');
			}
		}
	});
}
