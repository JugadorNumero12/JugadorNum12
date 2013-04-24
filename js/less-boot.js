window.less = {
    env: "development", // or "production"
    async: false,       // load imports async
    fileAsync: false,   // load imports async when in a page under
                        // a file protocol
    poll: 1000,         // when in watch mode, time in ms between polls
    functions: {},      // user functions, keyed by name
    dumpLineNumbers: "comments", // or "mediaquery" or "all"
    relativeUrls: false,// whether to adjust urls to be relative
                        // if false, urls are already relative to the
                        // entry less file
    //rootpath: baseUrl + '/'  // a path to add on to the start of every url
                        //resource
};