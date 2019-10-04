/*load dictionary*/
var dictionary = new Typo("en_US",undefined,undefined,{asyncLoad:true});

/* Text To Speech Listener */
function ttsListener(request){
    if(request.toDo == "tts")
    {
        if (request.option == "Justin" || request.option == "Ivy") {
            $.ajax({
                dataType: "json",
                type: "GET",
                url: "https://cast.boisestate.edu/extension/tts.php",
                data: {
                    "speech": request.toSay,
                    "voice": request.option 
                },
                success: function(result) {
                    var audio = new Audio();
                    audio.src = result;
                    audio.load();
                    audio.play();
                },
                error: function(xhr, textStatus, error) {
                    console.log("An error was encountered trying to speak!");
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(JSON.stringify(error));
                }
            });
        }
    }
};

/* Image Search Listener - makes request for images to php server */
function imageSearchListener(request) {
    if (request.toDo == "imageSearch") {
        $(function() {
            $.ajax({
                dataType: "json",
                type: "GET",
                url: "https://cast.boisestate.edu/googleAPI/googleImages.php",
                data: {
                    "keyword" : request.keyword
                },
                success: function(result) {
                    gotImageListener(
                        {
                            todo: "gotImage",
                            message: "success",
                            query: request.keyword,
                            result: result,
                            eid: request.eid,
                            newCache: request.newCache
                        }
                    );
                },
                error: function(xhr, textStatus, error) {
                    gotImageListener(
                        {
                            todo: "gotImage",
                            message: "error",
                            xhr: xhr,
                            textStatus: textStatus,
                            error: error,
                            newCache: request.newCache
                        }
                    );
                }
            });
        });
    } 
};

/* 
    Spell Check Listener - makes request for suggestions to php server
    Note that we use async await here, instead of callback functions.
    We decided that async handling for suggestions would be best in order to avoid errors.
*/
async function spellcheckListener(request) {
    let result;
    console.log("checking call to nodespellsheck");
    if (request.toDo == "spellCheck") {
        try {
            result = await $.ajax({
                dataType: "json",
                type: "GET",
                url: "https://cast.boisestate.edu/nodeAPI/nodeSpellcheck.php",
                data: {
                    "keyword" : request.keyword
                }
            });
        } catch (error) {
            result = error;
        }
    }
    return result;
};

/* Makes request for search results to php server */
function webSearchListener(request) {
    if (request.toDo == "webSearch") {

        $(function() {
            $.ajax({
                dataType: "json",
                type: "GET",
                url:  "https://cast.boisestate.edu/googleAPI/googleSearch.php",
                data: {
                    "keyword" : request.keyword
                },
                success: function(result) {
                    gotWebSearchListener(
                        {
                            todo: "gotWebSearch",
                            message: "success",
                            query: request.keyword,
                            result: result
                        }
                    );
                },
                error: function(xhr, textStatus, error) {
                    gotWebSearchListener(
                        {
                            todo: "gotWebSearch",
                            message: "error",
                            xhr: xhr,
                            textStatus: textStatus,
                            error: error
                        }
                    );
                }
            });
        });
    } 
};