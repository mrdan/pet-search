//On load page, init the timer which check if the there are anchor changes each 300 ms
$(document).ready(function() {
    
   // setInterval("checkAnchor()", 30);
});
    
    var currentAnchor = null;

    function checkAnchor() {
	   //Check if it has changes
    	if(currentAnchor != document.location.hash) {
	       currentAnchor = document.location.hash;
    		//if there is not anchor, the loads the default section
            if(!currentAnchor)
		      query = "g=1";
		    else
		    {
                //Creates the  string callback. This converts the url URL/#main&amp;amp;id=2 in URL/?section=main&amp;amp;id=2
			    var splits = currentAnchor.substring(1).split('&amp;amp;');
			    //Get the section
			    var section = splits[0];
			    delete splits[0];
			    //Create the params string
			    var params = splits.join('&amp;amp;');
			    var query = "g=" + section + params;
		     }
          //Send the petition
		  $.get("filter.php",query, function(data) {
            $("#main").html(data);
		  });
	    }
	  }
