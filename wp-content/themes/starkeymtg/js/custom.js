function loadProducts(jsonUrl) {
    //Load products after load page
    jQuery.ajax({
        url: jsonUrl,
        //force to handle it as text
        dataType: "text",
        success: function(data) {
            var json = jQuery.parseJSON(data);
            //Display product data
            for(var i=0;i<json.length;i++) {
                alert(json[i].productName);
                break;
            }
        }
    });
}