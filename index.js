function adblock_detect() {
    var iframe = document.createElement("iframe");
    iframe.height = "1px";
    iframe.width = "1px";
    iframe.id = "ads-text-iframe";
    iframe.src = "http://example.com/ads.html";
 
    document.body.appendChild(iframe);
 
    setTimeout(function() {
        var iframe = document.getElementById("ads-text-iframe");
        if (iframe.style.display == "none" || iframe.style.display == "hidden" || iframe.style.visibility == "hidden" || iframe.offsetHeight == 0) {
             
            adblock_blocking_ads();
 
            iframe.remove();
        } 
        else
        {
 
            iframe.remove();
        }
    }, 100);
}
 
function adblock_blocking_ads()
{
  var blockwebsite = document.getElementById("anti-adblock-disable-website").getAttribute("data-value");
  var alternativeads = document.getElementById("anti-adblock-alternative-ads").getAttribute("data-value");
 
  if(blockwebsite == "true")
  {
    var url = document.getElementById("anti-adblock-disable-website-url").getAttribute("data-value");
    document.body.innerHTML = "<div style='position: fixed; width: 100%; height: 100%; background-color:black; background-repeat: no-repeat; background-position: center center; background-image: url(" + url + ");'></div>";
  }
  else if(alternativeads == "true")
  {
    var count = document.getElementById("anti-adblock-alternative-ads").getAttribute("data-count");
 
    for(var iii = 1; iii <= count; iii++)
    {
      var selector = document.querySelector("#alternative_ads_selector_" + iii).innerHTML;
 
      if(selector != null)
      {
        document.querySelector(selector).innerHTML = htmlDecode(document.querySelector("#alternative_ads_code_" + iii).innerHTML);
      }
    }
  }
}
 
function htmlDecode(input) {
  var e = document.createElement('div');
  e.innerHTML = input;
  return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}
 
window.addEventListener("load", function(){
  adblock_detect();
}, false);