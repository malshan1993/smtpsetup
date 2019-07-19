var data = { 
    name : "your data" ,
    phone : "your data",
    email : "your data",
    message : "your data" 
}
$.ajax({
    method: "POST",
    url: '/email-plug.php',
    data: data,
    beforeSend: function() {
        // Before Send Message
    }
})
.done(function( data ) {
    // Done Message
});