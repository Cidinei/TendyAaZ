(window.webpackJsonp=window.webpackJsonp||[]).push([[32],{213:function(e,t,a){"use strict";function r(e,t){var a=t.left,r=t.right,n=t.mirror,o=t.opposite,s=(a?1:0)|(r?2:0)|(n?16:0)|(o?32:0)|(e?64:0);if(m.hasOwnProperty(s))return m[s];if(!n!=!(e&&o)){var i=[r,a];a=i[0],r=i[1]}var c=a?"-100%":r?"100%":"0",u=e?"from {\n        opacity: 1;\n      }\n      to {\n        transform: translate3d("+c+", 0, 0) skewX(30deg);\n        opacity: 0;\n      }\n    ":"from {\n        transform: translate3d("+c+", 0, 0) skewX(-30deg);\n        opacity: 0;\n      }\n      60% {\n        transform: skewX(20deg);\n        opacity: 1;\n      }\n      80% {\n        transform: skewX(-5deg);\n        opacity: 1;\n      }\n      to {\n        transform: none;\n        opacity: 1;\n      }";return m[s]=(0,l.animation)(u),m[s]}function n(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:l.defaults,t=e.children,a=(e.out,e.forever),n=e.timeout,o=e.duration,s=void 0===o?l.defaults.duration:o,c=e.delay,u=void 0===c?l.defaults.delay:c,m=e.count,p=void 0===m?l.defaults.count:m,g=function(e,t){var a={};for(var r in e)t.indexOf(r)>=0||Object.prototype.hasOwnProperty.call(e,r)&&(a[r]=e[r]);return a}(e,["children","out","forever","timeout","duration","delay","count"]),h={make:r,duration:void 0===n?s:n,delay:u,forever:a,count:p,style:{animationFillMode:"both"}};return g.left,g.right,g.mirror,g.opposite,(0,i.default)(g,h,h,t)}Object.defineProperty(t,"__esModule",{value:!0});var o,s=a(76),i=(o=s)&&o.__esModule?o:{default:o},c=a(2),l=a(57),u={out:c.bool,left:c.bool,right:c.bool,mirror:c.bool,opposite:c.bool,duration:c.number,timeout:c.number,delay:c.number,count:c.number,forever:c.bool},m={};n.propTypes=u,t.default=n,e.exports=t.default},214:function(e,t,a){"use strict";var r=a(4),n=a(5),o=a(8),s=a(7),i=a(9),c=a(0),l=a.n(c),u=a(18),m=a.n(u),p=a(213),g=a.n(p),h=function(e){function t(){var e,a;Object(r.a)(this,t);for(var n=arguments.length,i=new Array(n),c=0;c<n;c++)i[c]=arguments[c];return(a=Object(o.a)(this,(e=Object(s.a)(t)).call.apply(e,[this].concat(i)))).state={shareButton:!1},a.shareLink=function(e){navigator.share&&navigator.share({url:e.link}).then(function(){return console.log("Successful share")}).catch(function(e){return console.log("Error sharing",e)})},a}return Object(i.a)(t,e),Object(n.a)(t,[{key:"componentDidMount",value:function(){navigator.share&&this.setState({shareButton:!0})}},{key:"render",value:function(){var e=this;return l.a.createElement(l.a.Fragment,null,this.state.shareButton&&l.a.createElement("button",{type:"button",className:"btn search-navs-btns nav-home-btn",style:{position:"relative"},onClick:function(){return e.shareLink(e.props)}},l.a.createElement("i",{className:"si si-share"}),l.a.createElement(m.a,{duration:"500"})))}}]),t}(c.Component),d=function(e){function t(){return Object(r.a)(this,t),Object(o.a)(this,Object(s.a)(t).apply(this,arguments))}return Object(i.a)(t,e),Object(n.a)(t,[{key:"render",value:function(){var e=this;return l.a.createElement(l.a.Fragment,null,l.a.createElement("div",{className:"col-12 p-0 fixed",style:{zIndex:"9"}},l.a.createElement("div",{className:"block m-0"},l.a.createElement("div",{className:"block-content p-0 ".concat(this.props.dark&&"nav-dark")},l.a.createElement("div",{className:"input-group ".concat(this.props.boxshadow&&"search-box")},!this.props.disable_back_button&&l.a.createElement("div",{className:"input-group-prepend"},this.props.back_to_home&&l.a.createElement("button",{type:"button",className:"btn search-navs-btns",style:{position:"relative"},onClick:function(){setTimeout(function(){e.context.router.history.push("/")},200)}},l.a.createElement("i",{className:"si si-arrow-left"}),l.a.createElement(m.a,{duration:"500"})),this.props.goto_orders_page&&l.a.createElement("button",{type:"button",className:"btn search-navs-btns",style:{position:"relative"},onClick:function(){setTimeout(function(){e.context.router.history.push("/my-orders")},200)}},l.a.createElement("i",{className:"si si-arrow-left"}),l.a.createElement(m.a,{duration:"500"})),this.props.goto_accounts_page&&l.a.createElement("button",{type:"button",className:"btn search-navs-btns",style:{position:"relative"},onClick:function(){setTimeout(function(){e.context.router.history.push("/my-account")},200)}},l.a.createElement("i",{className:"si si-arrow-left"}),l.a.createElement(m.a,{duration:"500"})),!this.props.back_to_home&&!this.props.goto_orders_page&&!this.props.goto_accounts_page&&l.a.createElement("button",{type:"button",className:"btn search-navs-btns ".concat(this.props.dark&&"nav-dark"),style:{position:"relative"},onClick:function(){setTimeout(function(){e.context.router.history.goBack()},200)}},l.a.createElement("i",{className:"si si-arrow-left"}),l.a.createElement(m.a,{duration:"500"}))),l.a.createElement("p",{className:"form-control search-input d-flex align-items-center ".concat(this.props.dark&&"nav-dark")},this.props.logo&&l.a.createElement("img",{src:"/assets/img/logos/logo.png",alt:localStorage.getItem("storeName"),width:"120"}),this.props.has_title?l.a.createElement(l.a.Fragment,null,this.props.from_checkout?l.a.createElement("span",{className:"nav-page-title"},localStorage.getItem("cartToPayText")," ",l.a.createElement("span",{style:{color:localStorage.getItem("storeColor")}},"left"===localStorage.getItem("currencySymbolAlign")&&localStorage.getItem("currencyFormat"),this.props.title,"right"===localStorage.getItem("currencySymbolAlign")&&localStorage.getItem("currencyFormat"))):l.a.createElement("span",{className:"nav-page-title"},this.props.title)):null,this.props.has_delivery_icon&&l.a.createElement(g.a,{left:!0},l.a.createElement("img",{src:"/assets/img/various/delivery-bike.png",alt:this.props.title,className:"nav-page-title"}))),this.props.has_restaurant_info?l.a.createElement("div",{className:"fixed-restaurant-info hidden",ref:function(t){e.heading=t}},l.a.createElement("span",{className:"font-w700 fixedRestaurantName"},this.props.restaurant.name),l.a.createElement("br",null),l.a.createElement("span",{className:"font-w400 fixedRestaurantTime"},l.a.createElement("i",{className:"si si-clock"})," ",this.props.restaurant.delivery_time," ",localStorage.getItem("homePageMinsText"))):null,l.a.createElement("div",{className:"input-group-append"},!this.props.disable_search&&l.a.createElement("button",{type:"submit",className:"btn search-navs-btns",style:{position:"relative"}},l.a.createElement("i",{className:"si si-magnifier"}),l.a.createElement(m.a,{duration:"500"})),this.props.homeButton&&l.a.createElement("button",{type:"button",className:"btn search-navs-btns nav-home-btn",style:{position:"relative"},onClick:function(){setTimeout(function(){e.context.router.history.push("/")},200)}},l.a.createElement("i",{className:"si si-home"}),l.a.createElement(m.a,{duration:"500"})),this.props.shareButton&&l.a.createElement(h,{link:window.location.href})))))))}}]),t}(c.Component);d.contextTypes={router:function(){return null}};t.a=d},234:function(e,t,a){"use strict";var r=a(4),n=a(5),o=a(8),s=a(7),i=a(9),c=a(0),l=a.n(c),u=a(214),m=a(48),p=a(168),g=a(16),h=a(58),d=function(e){function t(){var e,a;Object(r.a)(this,t);for(var n=arguments.length,i=new Array(n),c=0;c<n;c++)i[c]=arguments[c];return(a=Object(o.a)(this,(e=Object(s.a)(t)).call.apply(e,[this].concat(i)))).state={withLinkToRestaurant:!1,isFavorite:!1},a.fixedRestaurantInfo=function(e){a.child&&(e?a.child.heading.classList.add("hidden"):a.child.heading.classList.remove("hidden"))},a.scrollFunc=function(){if(document.documentElement.scrollTop>55){a.fixedRestaurantInfo(!1)}if(document.documentElement.scrollTop<55){a.fixedRestaurantInfo(!0)}},a.setFavoriteRestaurant=function(){var e=a.props,t=e.restaurant_info,r=e.user;r.success&&(t.is_favorited?a.refs.heartIcon.classList.remove("is-active"):a.refs.heartIcon.classList.add("is-active"),a.props.setFavoriteRest(r.data.auth_token,t.id))},a}return Object(i.a)(t,e),Object(n.a)(t,[{key:"componentDidMount",value:function(){this.setState({withLinkToRestaurant:this.props.withLinkToRestaurant}),this.props.history.location.state&&this.props.history.location.state.fromExplorePage&&this.setState({withLinkToRestaurant:this.props.history.location.state.fromExplorePage}),this.registerScrollEvent()}},{key:"componentWillUnmount",value:function(){this.removeScrollEvent()}},{key:"registerScrollEvent",value:function(){window.addEventListener("scroll",this.scrollFunc)}},{key:"removeScrollEvent",value:function(){window.removeEventListener("scroll",this.scrollFunc)}},{key:"render",value:function(){var e=this,t=this.props,a=t.history,r=t.restaurant,n=t.user;return l.a.createElement(l.a.Fragment,null,l.a.createElement("div",{className:"bg-white"},l.a.createElement(u.a,{ref:function(t){e.child=t},history:a,boxshadow:!1,has_restaurant_info:!0,restaurant:r,disable_search:!0,homeButton:!0,shareButton:!0}),0===r.length?l.a.createElement(m.a,{height:170,width:400,speed:1.2,primaryColor:"#f3f3f3",secondaryColor:"#ecebeb"},l.a.createElement("rect",{x:"20",y:"70",rx:"4",ry:"4",width:"80",height:"78"}),l.a.createElement("rect",{x:"144",y:"85",rx:"0",ry:"0",width:"115",height:"18"}),l.a.createElement("rect",{x:"144",y:"115",rx:"0",ry:"0",width:"165",height:"16"})):l.a.createElement(l.a.Fragment,null,l.a.createElement(p.a,{to:"../../stores/"+r.slug,className:this.state.withLinkToRestaurant?"":"no-click"},l.a.createElement("div",{className:"d-flex pt-50"},l.a.createElement("div",{className:"px-15 mt-5"},l.a.createElement("img",{src:r.image,alt:r.name,className:"restaurant-image mt-0"})),l.a.createElement("div",{className:"mt-5 pb-15 w-100"},l.a.createElement("h4",{className:"font-w600 mb-5 text-dark"},r.name),l.a.createElement("div",{className:"font-size-sm text-muted truncate-text text-muted"},r.description),1===r.is_pureveg&&l.a.createElement("p",{className:"mb-0"},l.a.createElement("span",{className:"font-size-sm pr-1 text-muted"},localStorage.getItem("pureVegText")),l.a.createElement("img",{src:"/assets/img/various/pure-veg.png",alt:"PureVeg",style:{width:"20px"}})),l.a.createElement("div",{className:"text-center restaurant-meta mt-5 d-flex align-items-center justify-content-between text-muted"},"0"===r.avgRating?l.a.createElement("div",{className:"col-2 p-0 text-left"},l.a.createElement("i",{className:"fa fa-star",style:{color:localStorage.getItem("storeColor")}})," ",r.rating):l.a.createElement(p.a,{to:"/reviews/"+r.slug,style:{display:"contents"},className:"yes-click"},l.a.createElement("div",{className:"col-2 p-0 text-left store-rating-block"},l.a.createElement("i",{className:"fa fa-star",style:{color:localStorage.getItem("storeColor")}})," ",r.avgRating)),l.a.createElement("div",{className:"col-4 p-0 text-center store-distance-block"},l.a.createElement("i",{className:"si si-clock"})," ",r.delivery_time," ",localStorage.getItem("homePageMinsText")),l.a.createElement("div",{className:"col-6 p-0 text-center store-avgprice-block"},l.a.createElement("i",{className:"si si-wallet"})," ","left"===localStorage.getItem("currencySymbolAlign")&&l.a.createElement(l.a.Fragment,null,localStorage.getItem("currencyFormat"),r.price_range," "),"right"===localStorage.getItem("currencySymbolAlign")&&l.a.createElement(l.a.Fragment,null,r.price_range,localStorage.getItem("currencyFormat")," "),localStorage.getItem("homePageForTwoText")))))),n.success&&l.a.createElement("span",{onClick:this.setFavoriteRestaurant},l.a.createElement("div",{ref:"heartIcon",className:"heart ".concat(r.is_favorited&&"is-active")})))),"<p><br></p>"!==r.custom_message&&"null"!==r.custom_message&&""!==r.custom_message&&l.a.createElement("div",{style:{position:"relative",background:"#fff"},dangerouslySetInnerHTML:{__html:r.custom_message}}))}}],[{key:"getDerivedStateFromProps",value:function(e,t){return e.restaurant_info!==t.restaurant_info?{data:e.restaurant_info}:null}}]),t}(c.Component);t.a=Object(g.b)(function(e){return{restaurant_info:e.items.restaurant_info,user:e.user.user}},{setFavoriteRest:h.l})(d)},247:function(e,t,a){"use strict";a.d(t,"c",function(){return c}),a.d(t,"a",function(){return l}),a.d(t,"b",function(){return u});var r=a(63),n=a(15),o=a(6),s=a(3),i=a.n(s),c=function(e){return function(t){return i.a.get(o.M+"/"+e).then(function(e){var a=e.data.restaurant,o=e.data.reviews;return[t({type:n.b,payload:a}),t({type:r.c,payload:o})]}).catch(function(e){console.log(e)})}},l=function(e){return function(t){return i.a.post(o.b,{order_id:e.order_id,token:e.auth_token,rating_store:e.rating_store,rating_delivery:e.rating_delivery,review_store:e.review_store,review_delivery:e.review_delivery}).then(function(e){var a=e.data;return t({type:r.a,payload:a})}).catch(function(e){console.log(e)})}},u=function(e,t){return function(a){i.a.post(o.F,{order_id:e,token:t}).then(function(e){var t=e.data;return a({type:r.b,payload:t})}).catch(function(e){console.log(e)})}}},337:function(e,t,a){"use strict";a.r(t);var r=a(4),n=a(5),o=a(8),s=a(7),i=a(9),c=a(0),l=a.n(c),u=a(16),m=a(247),p=a(42),g=a(214),h=a(13),d=a(234),f=a(58),v=function(e){function t(){var e,a;Object(r.a)(this,t);for(var n=arguments.length,i=new Array(n),c=0;c<n;c++)i[c]=arguments[c];return(a=Object(o.a)(this,(e=Object(s.a)(t)).call.apply(e,[this].concat(i)))).state={loading:!0},a.getRatingStars=function(e){var t="rating-green";return e<=3&&(t="rating-orange"),e<=2&&(t="rating-red"),l.a.createElement("span",{className:"store-rating "+t},e," ",l.a.createElement("i",{className:"fa fa-star text-white"}))},a}return Object(i.a)(t,e),Object(n.a)(t,[{key:"componentDidMount",value:function(){var e=this;this.props.user.success?this.props.getRestaurantInfoForLoggedInUser(this.props.match.params.slug):this.props.getRestaurantInfo(this.props.match.params.slug),this.props.getReviewsForStore(this.props.match.params.slug).then(function(t){t&&e.setState({loading:!1})})}},{key:"render",value:function(){var e=this,t=this.props,a=t.reviews,r=t.restaurant_info;return l.a.createElement(l.a.Fragment,null,l.a.createElement(p.a,{seotitle:localStorage.getItem("reviewsPageTitle"),seodescription:localStorage.getItem("seoMetaDescription"),ogtype:"website",ogtitle:localStorage.getItem("seoOgTitle"),ogdescription:localStorage.getItem("seoOgDescription"),ogurl:window.location.href,twittertitle:localStorage.getItem("seoTwitterTitle"),twitterdescription:localStorage.getItem("seoTwitterDescription")}),l.a.createElement(g.a,{boxshadow:!0,has_title:!0,title:localStorage.getItem("reviewsPageTitle"),disable_search:!0,homeButton:!0}),this.state.loading?l.a.createElement(h.a,null):l.a.createElement(l.a.Fragment,null,l.a.createElement(d.a,{history:this.props.history,restaurant:r,withLinkToRestaurant:!0}),l.a.createElement("div",{className:"pt-20 px-15 height-100 bg-light"},a.map(function(t){return l.a.createElement("div",{className:"single-review"},l.a.createElement("p",{className:"mb-0"},l.a.createElement("strong",null,t.username)," ",l.a.createElement("span",{className:"ml-1"},e.getRatingStars(t.rating_store))),l.a.createElement("p",{className:"mb-2"},t.review_store))}))))}}]),t}(c.Component);v.contextTypes={router:function(){return null}};t.default=Object(u.b)(function(e){return{reviews:e.rating.reviews,restaurant_info:e.items.restaurant_info,user:e.user.user}},{getReviewsForStore:m.c,getRestaurantInfo:f.b,getRestaurantInfoForLoggedInUser:f.e})(v)}}]);