(window.webpackJsonp=window.webpackJsonp||[]).push([[35],{219:function(e,t,a){"use strict";a.d(t,"b",function(){return l}),a.d(t,"c",function(){return i}),a.d(t,"a",function(){return c}),a.d(t,"d",function(){return d});var n=a(32),s=a(6),r=a(3),o=a.n(r),l=function(e,t,a){return function(r){o.a.post(s.p,{user_id:e,token:t,restaurant_id:a}).then(function(e){var t=e.data;return r({type:n.b,payload:t})}).catch(function(e){console.log(e)})}},i=function(e,t,a,r,l,i,c,d){return function(u){o.a.post(s.jb,{token:t,user_id:e,latitude:a,longitude:r,address:l,house:i,tag:c,get_only_default_address:d}).then(function(e){var t=e.data;return u({type:n.c,payload:t})}).catch(function(e){console.log(e)})}},c=function(e,t,a){return function(r){o.a.post(s.l,{token:a,user_id:e,address_id:t}).then(function(e){var t=e.data;return r({type:n.a,payload:t})}).catch(function(e){console.log(e)})}},d=function(e,t,a){return function(r){return o.a.post(s.pb,{token:a,user_id:e,address_id:t}).then(function(e){var t=e.data;return r({type:n.d,payload:t})}).catch(function(e){console.log(e)})}}},224:function(e,t,a){"use strict";var n=a(4),s=a(5),r=a(8),o=a(7),l=a(9),i=a(0),c=a.n(i),d=a(18),u=a.n(d),m=a(345),g=a(340),p=a(329),h=function(e){function t(){var e,a;Object(n.a)(this,t);for(var s=arguments.length,l=new Array(s),i=0;i<s;i++)l[i]=arguments[i];return(a=Object(r.a)(this,(e=Object(o.a)(t)).call.apply(e,[this].concat(l)))).state={dropdownItem:null},a.handleSetDefaultAddress=function(e,t){e.target.classList.contains("si")||a.props.handleSetDefaultAddress(t.id,t)},a.handleDropdown=function(e){a.setState({dropdownItem:e.currentTarget})},a.handleDropdownClose=function(){a.setState({dropdownItem:null})},a}return Object(l.a)(t,e),Object(s.a)(t,[{key:"render",value:function(){var e=this,t=this.props,a=t.user,n=t.address;return c.a.createElement(c.a.Fragment,null,c.a.createElement("div",{className:!n.is_operational&&this.props.fromCartPage?"bg-white single-address-card d-flex no-click":"bg-white single-address-card d-flex",onClick:function(t){return e.handleSetDefaultAddress(t,n)},style:{position:"relative"}},c.a.createElement("div",{className:!n.is_operational&&this.props.fromCartPage?"address-not-usable w-100":"w-100"},a.data.default_address_id===n.id?c.a.createElement("button",{className:"btn btn-sm pull-right btn-address-default p-0 m-0",style:{border:"0",right:"0px",fontSize:"1.3rem"}},c.a.createElement("i",{className:"si si-check",style:{color:localStorage.getItem("storeColor")}}),c.a.createElement(u.a,{duration:200})):c.a.createElement(c.a.Fragment,null,this.props.fromCartPage&&c.a.createElement(c.a.Fragment,null,!n.is_operational&&c.a.createElement("span",{className:"text-danger text-uppercase font-w600 text-sm08"}," ",c.a.createElement("i",{className:"si si-close"})," ",localStorage.getItem("addressDoesnotDeliverToText")))),null!==n.tag&&c.a.createElement("h6",{className:"m-0 text-uppercase"},c.a.createElement("strong",null,n.tag)),c.a.createElement("div",null,null!==n.house&&c.a.createElement("p",{className:"m-0 text-capitalize"},null===n.tag?c.a.createElement("strong",null,n.house):c.a.createElement("span",null,n.house)),c.a.createElement("p",{className:"m-0 text-capitalize text-sm08"},n.address))),c.a.createElement("div",null,!this.props.fromCartPage&&this.props.deleteButton&&c.a.createElement(c.a.Fragment,null,a.data.default_address_id!==n.id&&c.a.createElement("button",{className:"btn btn-sm pull-right btn-address-default p-0 m-0 btn-delete-address",style:{border:"0",right:"0px",fontSize:"1.3rem",zIndex:2}},c.a.createElement("i",{className:"si si-trash",style:{fontSize:"1.3rem"},onClick:this.handleDropdown})))),c.a.createElement(u.a,{duration:500,hasTouch:!0})),c.a.createElement(m.a,{id:"simple-menu",keepMounted:!0,anchorEl:this.state.dropdownItem,open:Boolean(this.state.dropdownItem),onClose:this.handleDropdownClose,TransitionComponent:p.a,MenuListProps:{disablePadding:!0},elevation:3,getContentAnchorEl:null,anchorOrigin:{vertical:"bottom",horizontal:"center"},transformOrigin:{vertical:"top",horizontal:"center"}},c.a.createElement(g.a,{onClick:function(){e.props.handleDeleteAddress(n.id),e.handleDropdownClose()}},localStorage.getItem("deleteAddressText"))))}}]),t}(i.Component);t.a=h},263:function(e,t,a){"use strict";a.r(t);var n=a(4),s=a(5),r=a(8),o=a(7),l=a(9),i=a(0),c=a.n(i),d=a(77),u=a.n(d),m=a(223),g=a(42),p=a(48),h=a(18),f=a.n(h),E=function(e){function t(){return Object(n.a)(this,t),Object(r.a)(this,Object(o.a)(t).apply(this,arguments))}return Object(l.a)(t,e),Object(s.a)(t,[{key:"render",value:function(){var e=this.props,t=e.loading,a=e.locations,n=e.handleGeoLocationClick;return c.a.createElement(c.a.Fragment,null,c.a.createElement("div",{className:"p-15 mt-15"},t?c.a.createElement(c.a.Fragment,null,c.a.createElement("h1",{className:"text-muted h4"},localStorage.getItem("searchPopularPlaces")),c.a.createElement(p.a,{height:160,width:400,speed:1.2,primaryColor:"#f3f3f3",secondaryColor:"#ecebeb"},c.a.createElement("rect",{x:"0",y:"0",rx:"15",ry:"15",width:"125",height:"30"}),c.a.createElement("rect",{x:"135",y:"0",rx:"15",ry:"15",width:"100",height:"30"}),c.a.createElement("rect",{x:"245",y:"0",rx:"15",ry:"15",width:"110",height:"30"}),c.a.createElement("rect",{x:"0",y:"40",rx:"15",ry:"15",width:"85",height:"30"}),c.a.createElement("rect",{x:"95",y:"40",rx:"15",ry:"15",width:"125",height:"30"}))):c.a.createElement(c.a.Fragment,null,a.length>0&&c.a.createElement("h1",{className:"text-muted h4"},localStorage.getItem("searchPopularPlaces")),a.map(function(e,t){return c.a.createElement(u.a,{top:!0,delay:50*t,key:e.id},c.a.createElement("button",{type:"button",className:"btn btn-rounded btn-alt-secondary btn-md mb-15 mr-15",style:{position:"relative"},onClick:function(){var t=[{formatted_address:e.name,geometry:{location:{lat:e.latitude,lng:e.longitude}}}];n(t)}},c.a.createElement(f.a,{duration:"500"}),e.name))}))))}}]),t}(i.Component),y=a(362),v=a(16),b=a(101),S=a(6),C=a(3),N=a.n(C),_=a(219),w=a(224),x=function(e){function t(){var e,a;Object(n.a)(this,t);for(var s=arguments.length,l=new Array(s),i=0;i<s;i++)l[i]=arguments[i];return(a=Object(r.a)(this,(e=Object(o.a)(t)).call.apply(e,[this].concat(l)))).state={google_script_loaded:!1,loading_popular_location:!0,gps_loading:!1},a.handleGeoLocationClick=function(e){new Promise(function(t){localStorage.setItem("geoLocation",JSON.stringify(e[0])),t("GeoLocation Saved")}).then(function(){a.setState({gps_loading:!1}),a.context.router.history.push("/my-location")})},a.getMyLocation=function(){var e=navigator&&navigator.geolocation;console.log("LOCATION",e),a.setState({gps_loading:!0}),e&&e.getCurrentPosition(function(e){a.reverseLookup(e.coords.latitude,e.coords.longitude)},function(e){a.setState({gps_loading:!1}),console.log(e),alert(localStorage.getItem("gpsAccessNotGrantedMsg"))},{timeout:5e3})},a.reverseLookup=function(e,t){N.a.post(S.q,{lat:e,lng:t}).then(function(n){console.log(n);var s=[{formatted_address:n.data,geometry:{location:{lat:e,lng:t}}}];a.handleGeoLocationClick(s)}).catch(function(e){console.warn(e.response.data)})},a.handleSetDefaultAddress=function(e,t){var n=a.props.user;n.success&&a.props.setDefaultAddress(n.data.id,e,n.data.auth_token).then(function(){new Promise(function(e){var a={lat:t.latitude,lng:t.longitude,address:t.address,house:t.house,tag:t.tag};localStorage.setItem("userSetAddress",JSON.stringify(a)),e("Address Saved")}).then(function(){"1"===localStorage.getItem("fromCart")?(localStorage.removeItem("fromCart"),a.context.router.history.push("/cart")):a.context.router.history.push("/")})})},a}return Object(l.a)(t,e),Object(s.a)(t,[{key:"componentDidMount",value:function(){var e=this;if(this.props.getPopularLocations(),this.searchInput&&this.searchInput.focus(),!document.getElementById("googleMaps")){var t=document.createElement("script");t.src="https://maps.googleapis.com/maps/api/js?key="+localStorage.getItem("googleApiKey")+"&libraries=places",t.id="googleMaps",document.body.appendChild(t),t.onload=function(){e.setState({google_script_loaded:!0})}}}},{key:"componentWillUnmount",value:function(){var e=document.getElementById("googleMaps");e&&e.parentNode.removeChild(e)}},{key:"componentWillReceiveProps",value:function(e){this.props.popular_locations!==e.popular_locations&&this.setState({loading_popular_location:!1})}},{key:"render",value:function(){var e=this;if(window.innerWidth>768)return c.a.createElement(y.a,{to:"/"});if(null===localStorage.getItem("storeColor"))return c.a.createElement(y.a,{to:"/"});var t=this.props,a=t.user,n=t.popular_locations,s=t.addresses;return c.a.createElement(c.a.Fragment,null,c.a.createElement(g.a,{seotitle:localStorage.getItem("seoMetaTitle"),seodescription:localStorage.getItem("seoMetaDescription"),ogtype:"website",ogtitle:localStorage.getItem("seoOgTitle"),ogdescription:localStorage.getItem("seoOgDescription"),ogurl:window.location.href,twittertitle:localStorage.getItem("seoTwitterTitle"),twitterdescription:localStorage.getItem("seoTwitterDescription")}),this.state.gps_loading&&c.a.createElement("div",{className:"height-100 overlay-loading ongoing-payment-spin"},c.a.createElement("div",{className:"spin-load"})),c.a.createElement("div",{className:"col-12 p-0 pt-0"},this.state.google_script_loaded&&c.a.createElement(m.a,{debounce:750,withSessionToken:!0,loader:c.a.createElement("img",{src:"/assets/img/various/spinner.svg",className:"location-loading-spinner",alt:"loading"}),renderInput:function(t){return c.a.createElement("div",{className:"input-location-icon-field"},c.a.createElement("i",{className:"si si-magnifier"}),c.a.createElement("div",{className:"input-group-prepend"},c.a.createElement("button",{type:"button",className:"btn search-navs-btns location-back-button",style:{position:"relative"},onClick:function(){return e.context.router.history.goBack()}},c.a.createElement("i",{className:"si si-arrow-left"}),c.a.createElement(f.a,{duration:"500"})),c.a.createElement("input",Object.assign({},t,{className:"form-control search-input",placeholder:localStorage.getItem("searchAreaPlaceholder"),ref:function(t){e.searchInput=t}}))))},renderSuggestions:function(t,a,n){return c.a.createElement("div",{className:"location-suggestions-container"},a.map(function(t,a){return c.a.createElement(u.a,{top:!0,delay:50*a,key:t.id},c.a.createElement("div",{className:"location-suggestion",onClick:function(a){n(t,a),Object(m.b)(t.place_id).then(function(t){return e.handleGeoLocationClick(t)}).catch(function(e){return console.error(e)})}},c.a.createElement("span",{className:"location-main-name"},t.structured_formatting.main_text),c.a.createElement("br",null),c.a.createElement("span",{className:"location-secondary-name"},t.structured_formatting.secondary_text)))}),c.a.createElement("img",{src:"/assets/img/various/powered_by_google_on_white.png",alt:"powered by Google",className:"pl-15"}))}}),c.a.createElement("button",{className:"btn btn-rounded btn-gps btn-md ml-15 mt-4 pl-0 py-15",style:{color:localStorage.getItem("storeColor")},onClick:this.getMyLocation},c.a.createElement("i",{className:"si si-pointer"})," ",localStorage.getItem("useCurrentLocationText"))),c.a.createElement(E,{loading:this.state.loading_popular_location,handleGeoLocationClick:this.handleGeoLocationClick,locations:n}),a.success&&s.length>0&&c.a.createElement(c.a.Fragment,null,c.a.createElement("div",{className:"p-15 mt-10 location-saved-address"},c.a.createElement("h1",{className:"text-muted h4"},localStorage.getItem("locationSavedAddresses")),s.map(function(t){return c.a.createElement(w.a,{handleDeleteAddress:e.handleDeleteAddress,deleteButton:!1,key:t.id,address:t,user:a,fromCartPage:!1,handleSetDefaultAddress:e.handleSetDefaultAddress})}))))}}]),t}(i.Component);x.contextTypes={router:function(){return null}};t.default=Object(v.b)(function(e){return{user:e.user.user,popular_locations:e.popular_locations.popular_locations,addresses:e.addresses.addresses}},{getPopularLocations:function(){return function(e){N.a.post(S.D).then(function(t){var a=t.data;return e({type:b.a,payload:a})}).catch(function(e){console.log(e)})}},getAddresses:_.b,setDefaultAddress:_.d})(x)},339:function(e,t,a){"use strict";a.r(t);var n=a(50),s=a(4),r=a(5),o=a(8),l=a(7),i=a(9),c=a(97),d=a(0),u=a.n(d),m=a(13),g=a(216),p=a.n(g),h=a(96),f=a(16),E=a(263),y=a(59),v=function(e){function t(){var e;return Object(s.a)(this,t),(e=Object(o.a)(this,Object(l.a)(t).call(this))).state={loading:!0,guestUser:!1,statusMsg:"",countryCodeSelect:"",name:"",email:"",phone:"",password:"",loggedinAsCustomer:!1,email_phone_already_used:!1,error:!1,errorMessage:"",guestRegisterSuccess:!1},e.handleInputChange=function(t){"phone"===t.target.name?(e.setState({phone:e.state.countryCodeSelect+t.target.value.replace(/^0+/,"")}),e.setState({onlyPhone:t.target.value.replace(/^0+/,"")})):e.setState(Object(n.a)({},t.target.name,t.target.value))},e.handleCountryCodeChange=function(t){var a=t.target;e.setState({countryCodeSelect:a.value},function(){e.setState({phone:a.value+e.state.onlyPhone})})},e.processDefaultCountryCode=function(){var t=localStorage.getItem("phoneCountryCode").split(",");return 0===t.length?u.a.createElement("span",{className:"country-code"}):1===t.length?u.a.createElement("span",{className:"country-code"},t[0].replace(/\s/g,"")):t.length>1?u.a.createElement("select",{name:"countryCodeSelect",onChange:e.handleCountryCodeChange,className:"country-code--dropdown"},t.map(function(e){return u.a.createElement("option",{key:e,value:e.replace(/\s/g,"")},e.replace(/\s/g,""))})):void 0},e.handleGuestRegister=function(t){t.preventDefault(),e.validator.fieldValid("name")&&e.validator.fieldValid("email")&&e.validator.fieldValid("phone")&&e.validator.fieldValid("password")?(e.setState({loading:!0}),e.props.registerGuestUser(e.state.name,e.state.phone,e.state.email,e.state.password)):(console.log("Validation Failed"),e.validator.showMessages())},e.validator=new p.a({autoForceUpdate:Object(c.a)(Object(c.a)(e)),messages:{required:localStorage.getItem("fieldValidationMsg"),string:localStorage.getItem("nameValidationMsg"),email:localStorage.getItem("emailValidationMsg"),regex:localStorage.getItem("phoneValidationMsg"),min:localStorage.getItem("minimumLengthValidationMessage")}}),e}return Object(i.a)(t,e),Object(r.a)(t,[{key:"componentDidMount",value:function(){var e=this,t=localStorage.getItem("phoneCountryCode").split(",");this.setState({countryCodeSelect:t[0].replace(/\s/g,"")});var a=this.props.match.params.id;"undefined"===typeof a?this.setState({loading:!1,guestUser:!0}):(this.setState({guestUser:!1}),this.props.loginAsCustomer(a).then(function(t){t&&t[0].payload&&t[0].payload.success&&e.setState({loading:!1,loggedinAsCustomer:!0})}))}},{key:"componentWillReceiveProps",value:function(e){var t=this;if(this.props.user!==e.user&&this.setState({loading:!1}),e.user.success&&null!==e.user.data.default_address){var a={lat:e.user.data.default_address.latitude,lng:e.user.data.default_address.longitude,address:e.user.data.default_address.address,house:e.user.data.default_address.house,tag:e.user.data.default_address.tag};localStorage.setItem("userSetAddress",JSON.stringify(a))}e.user.email_phone_already_used&&this.setState({email_phone_already_used:!0}),e.user||this.setState({error:!0}),e.user.success&&this.state.guestUser&&(console.log("User Registered and Loggedin"),this.setState({guestRegisterSuccess:!0}),setTimeout(function(){t.context.router.history.push("/search-location")},1880))}},{key:"render",value:function(){var e=this.props.user;return u.a.createElement(u.a.Fragment,null,u.a.createElement(y.Helmet,null,u.a.createElement("style",{type:"text/css"},"\n                    .location-back-button {\n                        display: none;\n                    }\n                    ")),this.state.loading&&u.a.createElement(m.a,null),this.state.email_phone_already_used&&u.a.createElement("div",{className:"auth-error"},u.a.createElement("div",{className:"error-shake"},localStorage.getItem("emailPhoneAlreadyRegistered"))),this.state.error&&u.a.createElement("div",{className:"auth-error"},u.a.createElement("div",{className:"error-shake"},""!==this.state.errorMessage?this.state.errorMessage:localStorage.getItem("loginErrorMessage"))),this.state.guestRegisterSuccess&&u.a.createElement(u.a.Fragment,null,u.a.createElement("div",{className:"update-full-notification d-block",style:{zIndex:9999999999,backgroundColor:"#fff"}},u.a.createElement("div",{style:{marginTop:"15rem"}},u.a.createElement("img",{src:"/assets/img/order-placed.gif",alt:"Successful",className:"img-fluid",style:{width:"120px"}})),u.a.createElement("div",{style:{marginTop:"4rem"},className:"text-center"},u.a.createElement("h3",{className:"text-dark mb-2"},"Registration Successful"),u.a.createElement("h5",{className:"mb-0"}," Loggedin as ",this.props.user.data.name)),u.a.createElement("div",{style:{marginTop:"4rem"},className:"text-center text-muted"},u.a.createElement("p",{className:"text-muted small"}," Redirecting please wait...")))),this.state.guestUser?u.a.createElement(u.a.Fragment,null,u.a.createElement("div",{className:"cust-auth-header"},u.a.createElement("div",{className:"input-group"},u.a.createElement("div",{className:"input-group-prepend"})),u.a.createElement("div",{className:"login-texts px-15 mt-30 pb-20"},u.a.createElement("span",{className:"login-title text-capitalize"},"Guest Customer"),u.a.createElement("br",null),u.a.createElement("span",{className:"login-subtitle"},"Enter the details"))),u.a.createElement("div",{className:"bg-white"},u.a.createElement("form",{onSubmit:this.handleGuestRegister,id:"registerForm"},u.a.createElement("div",{className:"form-group px-15 pt-30"},u.a.createElement("div",{className:"col-md-9 pb-5"},u.a.createElement("input",{type:"text",name:"name",onChange:this.handleInputChange,className:"form-control auth-input",placeholder:localStorage.getItem("loginLoginNameLabel")}),this.validator.message("name",this.state.name,"required|string")),u.a.createElement("div",{className:"col-md-9 pb-5"},u.a.createElement("div",null,this.processDefaultCountryCode(),u.a.createElement("span",null,u.a.createElement("input",{name:"phone",type:"tel",onChange:this.handleInputChange,className:"form-control phone-number-country-code auth-input",placeholder:localStorage.getItem("loginLoginPhoneLabel")}),this.validator.message("phone",this.state.phone,["required",{regex:["^\\+[1-9]\\d{1,14}$"]},{min:["8"]}])))),u.a.createElement("div",{className:"col-md-9 pb-5"},u.a.createElement("input",{type:"text",name:"email",onChange:this.handleInputChange,className:"form-control auth-input",placeholder:"Email is optional"}),this.validator.message("email",this.state.email,"email")),u.a.createElement("div",{className:"col-md-9"},u.a.createElement("input",{type:"password",name:"password",onChange:this.handleInputChange,className:"form-control auth-input",placeholder:"Password is optional"}),this.validator.message("password",this.state.password,"min:6"))),u.a.createElement("div",{className:"mt-20 mx-15 d-flex justify-content-center"},u.a.createElement("button",{type:"submit",className:"btn btn-main",style:{backgroundColor:localStorage.getItem("storeColor"),width:"90%",borderRadius:"4px"}},localStorage.getItem("firstScreenRegisterBtn")))))):u.a.createElement(u.a.Fragment,null,u.a.createElement("div",{className:"cust-auth-header"},u.a.createElement("div",{className:"input-group"},u.a.createElement("div",{className:"input-group-prepend"})),u.a.createElement("div",{className:"login-texts px-15 mt-30 pb-20"},u.a.createElement("span",{className:"login-title text-capitalize"},this.state.loggedinAsCustomer?u.a.createElement(u.a.Fragment,null,"Loggedin as ",e.data.name):u.a.createElement("span",null,"Logging in as Customer")),u.a.createElement("br",null),u.a.createElement("span",{className:"login-subtitle"},this.state.loggedinAsCustomer?u.a.createElement(u.a.Fragment,null,"Phone: ",e.data.phone," ",u.a.createElement("br",null),"Email: ",e.data.email):u.a.createElement("span",null,"Please Wait...")))),this.state.loggedinAsCustomer&&u.a.createElement(u.a.Fragment,null,u.a.createElement(E.default,null))),u.a.createElement("p",null,this.state.statusMsg))}}]),t}(d.Component);v.contextTypes={router:function(){return null}};t.default=Object(f.b)(function(e){return{user:e.user.user,settings:e.settings.settings,addresses:e.addresses.addresses}},{loginAsCustomer:h.g,registerGuestUser:h.k})(v)}}]);