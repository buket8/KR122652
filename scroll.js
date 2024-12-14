$(document).ready(function() {
    
    const form = $('#apply-form');
    if (form.length) {
        $('html, body').animate({
            scrollTop: form.offset().top
        }, 1000); 
    }
});
