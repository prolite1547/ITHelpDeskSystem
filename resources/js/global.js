export default class Route {
    constructor(window) {
        this.url = window.location.url;
        this.host     = window.location.host;   // www.somedomain.com (includes port if there is one[1])
        this.hostname = window.location.hostname;   // www.somedomain.com
        this.hash     = window.location.hash;   // #top
        this.href     = window.location.href;   // http://www.somedomain.com/account/search?filter=a#top
        this.pathname = window.location.pathname;   // /account/search
        this.port     = window.location.port;   // (port if there is one[1])
        this.protocol = window.location.protocol;   // http:
        this.search   = window.location.search;   // ?filter=a
    }

    getRoute() {
        var reg = /.+?\:\/\/.+?(\/.+?)(?:#|\?|$)/;
        return this.pathname = reg.exec( this.href )[1];
    }

    editRoute(id){
        return `${this.hostname}/ticket/edit/${id}`;
    }
};
