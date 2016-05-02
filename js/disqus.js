
'use strict';

var Disqus = function (disqusThreadConfig) {
    this.url = disqusThreadConfig ? (disqusThreadConfig.url || window.location.href) : window.location.href;
    this.id =  disqusThreadConfig ? (disqusThreadConfig.id || window.location.href) : window.location.href;
    this.title = disqusThreadConfig ? (disqusThreadConfig.title || document.title) : window.location.href;
};

/**
 * Loads a discussion thread identified by three parameters:
 *  - url
 *  - identifer
 *  - title
 * 
 * Note: Will return false if embed.js is not present in the DOM; Returns true otherwise
 */
Disqus.prototype.load = function () {
    var status = false;    
    if(DISQUS) {
        DISQUS.reset({
          reload: true,
          config: function () {  
              if (disqus && disqus instanceof Disqus) {
                    // Replace PAGE_URL with your page's canonical URL variable
                    // A unique URL for each page where Disqus is present
                    this.page.url = disqus.url;

                    // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    // A unique identifier for each page where Disqus is present
                    this.page.identifier = disqus.id;

                    this.page.title = disqus.title;
             } 
          }
       });
       status = true; 
    }    
    return status;
};


/**
 * Loads embed.js into the DOM. Call the function before loading any discussion thread.
 * Note: disqus.load() call will fail if embed.js doesn't load
 * onDiscussionJSLoaded is registered as a callback function when
 * embed.js is appended into the body
 */
Disqus.prototype.loadEmbed = function() {
     var d = document, s = d.createElement('script');
     if(typeof onDiscussionJSLoaded == 'function') {
         // Works for Chrome/Firefoxs
         s.setAttribute('onload', 'onDiscussionJSLoaded()');
         // Works for IE
         s.onreadystatechange = function() {
              if ( this.readyState != "loaded" ) return;
              onDiscussionJSLoaded();
         }
     }
     s.src = '//cosmoimmigration.disqus.com/embed.js';
     s.setAttribute('data-timestamp', +new Date());
     var nodeAppended = (d.head || d.body).appendChild(s);
     return nodeAppended;
}

/**
 * Global object.
 * Could be overriden
 */
var disqus = new Disqus();

/**
 * Required to load a default discussion.
 * Note: Do not change the name of the function
 * Used by http://cosmoimmigration.disqus.com/embed.js 
 */
var disqus_config = function () {
        if (disqus && disqus instanceof Disqus) {
            // Replace PAGE_URL with your page's canonical URL variable
            // A unique URL for each page where Disqus is present
            this.page.url = disqus.url;

            // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            // A unique identifier for each page where Disqus is present
            this.page.identifier = disqus.id;

            this.page.title = disqus.title;
        }        
};




