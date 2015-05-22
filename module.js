M.qtype_shortanswerdb = {}
M.qtype_shortanswerdb.prepare_answer_field = function(Y, topnode, inputname, inputnametext, inputnameid) {

                console.log(topnode);
                var inputform = Y.one(topnode).ancestor('form');
                //inputnametext = inputnametext.replace("\:", "\\:");
                var inputtext = Y.one('#' + inputnametext);
                console.log(document.getElementById(inputnametext).value);
                console.log(inputtext);

                if (inputform != null) {
                var nextbutton = inputform.one('input[type=submit]');
                nextbutton.on(['mousedown', 'touchstart'], function(e) {
		   console.log('here1');

                }, this);
                var previewsubmit = inputform.one('input[name="finish"]');
                }

                if (previewsubmit != null) {
                previewsubmit.on(['mousedown', 'touchstart'], function(e) {
                   console.log(document.getElementById(inputnametext).value)
                   var answer = document.getElementById(inputnameid).value + '&' + document.getElementById(inputnametext).value;
                   document.getElementById(inputname).value = answer;
		   console.log('here2');
                   console.log(inputnametext);
                   console.log(inputtext);
                    
                }, this);
                }
                var navbuttons = Y.all('a[id^="quiznavbutton"]');
                if (navbuttons != null) {
                navbuttons.on(['mousedown', 'touchstart'], function(e) {
		    console.log('here3');
                }, this);
                }

};
