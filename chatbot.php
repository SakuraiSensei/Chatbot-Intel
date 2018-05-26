<!DOCTYPE html>
<html lang="en">
<head>
<title>Chatbot Intel</title>
<link rel="stylesheet" type="text/css" href="./css/websitecss.css">
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.41.0.min.js"></script>
    <style language="text/css">


.buttons {
    overflow: hidden;
    background-color: #990099;
	float: center;

	
}

.buttons a {
    float: left;
    display: block;
    color: white;
    text-align: center;
    padding: 20px 25px;
    text-decoration: none;
}
	


.top {
	background-color:purple;
	color:white;
	
	text-align: center;
}

.buttons a:hover {
    background-color: #232629;
    color: white;
	
}

.text {
		float: center;
		padding: 40px;
		background-color: #cc00cc;
		margin: 40px 80px;

}

.page {
	width: 900px;
	height: 600px;
	margin: 0 auto;
	
	}
	
input#wisdom {
            padding: 4px;
            font-size: 1em;
            width: 400px
        }
    input::placeholder {
        color: #ccc;
        font-style: italic;
    }

    p.userRequest {
        margin: 4px;
        padding: 4px 10px 4px 10px;
        border-radius: 4px;
        min-width: 50%;
        max-width: 85%;
        float: left;
        background-color: #7d7;
    }

    p.lexResponse {
        margin: 4px;
        padding: 4px 10px 4px 10px;
        border-radius: 4px;
        text-align: right;
        min-width: 50%;
        max-width: 85%;
        float: right;
        background-color: #bbf;
        font-style: italic;
    }

    p.lexError {
        margin: 4px;
        padding: 4px 10px 4px 10px;
        border-radius: 4px;
        text-align: right;
        min-width: 50%;
        max-width: 85%;
        float: right;
        background-color: #f77;
    }	


</style>

</head>
<div class = "page">
<body style="background-color: #b300b3;">

<div class="top">


<img class="no-mobile1" src="img/banner.png" style="width:850px;">

</div>

<div class = "buttons">

<a href="index.html"><b>Home</b></a>
<a href="https://www.aut.ac.nz/study/study-options/engineering-computer-and-mathematical-sciences/courses/bachelor-of-computer-and-information-sciences/software-development-major"><b>Go to Official AUT website (Software development - BCIS)</b></a>
<a href="./module/chatform.php"><b>ChatBot Intel</b></a>
<a href="help.html"><b>Help Page</b></a>

</div>
<div class = "text">

<h1 style="text-align: left">ChatBot Intel - AUT Paper searcher</h1>

    <div id="conversation" style="width: 400px; height: 400px; border: 1px solid #ccc; background-color: #eee; padding: 4px; overflow: scroll"></div>
    <form id="chatform" style="margin-top: 10px" onsubmit="return pushChat();">
        <input type="text" id="wisdom" size="80" value="" placeholder="Type your question">
    </form>
    <script type="text/javascript">
        // set the focus to the input box
    document.getElementById("wisdom").focus();

// Initialize the Amazon Cognito credentials provider
AWS.config.region = 'us-west-2'; // Region
AWS.config.credentials = new AWS.CognitoIdentityCredentials({
    IdentityPoolId: 'us-west-2:b402862f-af14-4039-9e98-64ce1a1cd836',
});

    var lexruntime = new AWS.LexRuntime();
    var lexUserId = 'chatbot-demo' + Date.now();
    var sessionAttributes = {};

    function pushChat() {

        // if there is text to be sent...
        var wisdomText = document.getElementById('wisdom');
        if (wisdomText && wisdomText.value && wisdomText.value.trim().length > 0) {

            // disable input to show we're sending it
            var wisdom = wisdomText.value.trim();
            wisdomText.value = '...';
            wisdomText.locked = true;

	$LATEST = 'TestVersion';

            // send it to the Lex runtime
            var params = {
                botAlias: '$LATEST',
                botName: 'ChatBotIntel',
                inputText: wisdom,
                userId: lexUserId,
                sessionAttributes: sessionAttributes
            };
            showRequest(wisdom);
            lexruntime.postText(params, function(err, data) {
                if (err) {
                    console.log(err, err.stack);
                    showError('Error:  ' + err.message + ' (see console for details)')
                }
                if (data) {
                    // capture the sessionAttributes for the next cycle
                    sessionAttributes = data.sessionAttributes;
                    // show response and/or error/dialog status
                    showResponse(data);
                }
                // re-enable input
                wisdomText.value = '';
                wisdomText.locked = false;
            });
        }
        // we always cancel form submission
        return false;
    }

    function showRequest(daText) {

        var conversationDiv = document.getElementById('conversation');
        var requestPara = document.createElement("P");
        requestPara.className = 'userRequest';
        requestPara.appendChild(document.createTextNode(daText));
        conversationDiv.appendChild(requestPara);
        conversationDiv.scrollTop = conversationDiv.scrollHeight;
    }

    function showError(daText) {

        var conversationDiv = document.getElementById('conversation');
        var errorPara = document.createElement("P");
        errorPara.className = 'lexError';
        errorPara.appendChild(document.createTextNode(daText));
        conversationDiv.appendChild(errorPara);
        conversationDiv.scrollTop = conversationDiv.scrollHeight;
    }

    function showResponse(lexResponse) {

        var conversationDiv = document.getElementById('conversation');
        var responsePara = document.createElement("P");
        responsePara.className = 'lexResponse';
        if (lexResponse.message) {
            responsePara.appendChild(document.createTextNode(lexResponse.message));
            responsePara.appendChild(document.createElement('br'));
        }
        if (lexResponse.dialogState === 'ReadyForFulfillment') {
            responsePara.appendChild(document.createTextNode(
                'Ready for fulfillment'));
            // TODO:  show slot values
        } else {
/*
            responsePara.appendChild(document.createTextNode(
                '(' + lexResponse.dialogState + ')'));
*/
        }

        conversationDiv.appendChild(responsePara);
        conversationDiv.scrollTop = conversationDiv.scrollHeight;
    }
</script>
<P>
Questions can be... <BR><BR>
What are the pre-requisites and co-requisites for [a specific paper]? <BR>
If I take a [specific paper] what other papers should I take next for [the software dev major in the BCIS]? <BR>
What would be a suggested set of papers for a [the software dev major in the BCIS]? <BR>
Which papers are suitable for a [specific job] (like web developer, business analyst, software engineer, scrum master)? <BR>
If I have failed [specific paper] what papers can I still take? <BR>
What semesters is [specific paper] offered in [specific year]? <BR>
</P>

</div>


</body>
</div>
</html>