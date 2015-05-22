M.qtype_shortanswerdb = {}
M.qtype_shortanswerdb.prepare_answer_field = function(Y, topnode, inputname, inputnametext, inputnameid) {

                function parseanswer(e) {
                var answer = document.getElementById(inputnameid).value + '&' + document.getElementById(inputnametext).value;
                document.getElementById(inputname).value = answer;
                }

                var inputform = Y.one(topnode).ancestor('form');
                var inputtext = Y.one('#' + inputnametext);

                if (inputform != null) {
                var nextbutton = inputform.one('input[type=submit]');
                nextbutton.on(['mousedown', 'touchstart'], parseanswer, this);
                var previewsubmit = inputform.one('input[name="finish"]');
                }

                if (previewsubmit != null) {
                previewsubmit.on(['mousedown', 'touchstart'], parseanswer, this);
                }

                var navbuttons = Y.all('a[id^="quiznavbutton"]');
                if (navbuttons != null) {
                navbuttons.on(['mousedown', 'touchstart'], parseanswer, this);
                }

};
