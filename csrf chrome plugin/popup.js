// chrome.extension.onConnect.addListener(function(port) {
//   console.log("Connected .....");
//   port.onMessage.addListener(function(msg) {
//         console.log("message recieved"+ msg);
//         port.postMessage("Hi Background");
//   });
// });



// chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {

//     if (request.greeting){
//     	console.log(request.greeting);
//     	$('body').append("<h2>"+request.greeting+"</h2>");
//       sendResponse({farewell: "goodbye"});
//     } else {
//     	$('body').append("<h2>"+error+"</h2>");
//     }
//   });