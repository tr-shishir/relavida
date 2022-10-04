$(document).ready(function () {   
        var track = {referrer: document.referrer}
        $.ajax({
            url: mw.settings.api_url+'pingstats',
            data: track,
            type: "POST",
            dataType: "json",
            async: true
        });    
});



