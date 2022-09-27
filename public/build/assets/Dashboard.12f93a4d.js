import{_ as w}from"./AuthenticatedLayout.309fef95.js";import{j as n,o,D as c,b as g,u as f,e as u,F as i,H as v,E as s,r as p,t as e,G as l}from"./app.0ffe1c0a.js";const k=s("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Dashboard ",-1),O={class:"py-12"},D={class:"max-w-7xl mx-auto sm:px-6 lg:px-6 mb-5"},E={class:"overflow-hidden grid grid-flow-col-dense gap-4"},L={class:"bg-white p-5 m-5 shadow-lg sm:rounded-lg"},T={class:"text-center bg-emerald-400 rounded-full"},I={class:"p-1 text-white uppercase"},N=l("Market Status - "),S={class:"text-white"},P={class:"grid grid-cols-2 gap-4 my-2"},A=s("h1",null,[s("small",null,"Account ID")],-1),R=l(),C=s("p",null,[s("small",null,"Account Name")],-1),M={class:"grid grid-cols-2 gap-4"},B={class:"avalible"},G=s("p",{class:"font-bold"},"Current balance",-1),V={class:"blance"},W=s("p",{class:"font-bold"},"Opening balance",-1),z={class:"deposit"},F=s("p",{class:"font-bold"},"Deposit",-1),H={class:"profit"},K=s("p",{class:"font-bold"},"Profit/Loss",-1),U={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Z={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3"},$={class:"p-6 bg-white border-b border-gray-200"},j=s("h1",{class:"mb-4"},"Current Working Orders",-1),q={class:"table w-full text-sm text-left text-gray-500 dark:text-gray-400",id:"datatable_1"},Y=s("thead",{class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-white"},[s("tr",null,[s("th",{scope:"col",class:"px-6 py-3"}," MARKET "),s("th",{scope:"col",class:"px-6 py-3"}," DERECTION "),s("th",{scope:"col",class:"px-6 py-3"}," SIZE "),s("th",{scope:"col",class:"px-6 py-3"}," LEVEL "),s("th",{scope:"col",class:"px-6 py-3"}," LAST "),s("th",{scope:"col",class:"px-6 py-3"}," STOP "),s("th",{scope:"col",class:"px-6 py-3"}," LIMIT "),s("th",{scope:"col",class:"px-6 py-3"}," ORDER TYPE "),s("th",{scope:"col",class:"px-6 py-3"}," GOOD TILL "),s("th",{scope:"col",class:"px-6 py-3"},"Created at")])],-1),J={scope:"row",class:"px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap"},Q={class:"px-6 py-4"},X={class:"px-6 py-4"},ss={class:"px-6 py-4"},ts={class:"px-6 py-4"},es={class:"px-6 py-4"},as={class:"px-6 py-4"},os={class:"px-6 py-4"},cs={class:"px-6 py-4"},ls={class:"px-6 py-4"},rs={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},ds={class:"p-6 bg-white border-b border-gray-200"},is=s("h1",{class:"mb-4"},"Current Positions",-1),ns={class:"table w-full text-sm text-left text-gray-500 dark:text-gray-400",id:"datatable_1"},ps=s("thead",{class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-white"},[s("tr",null,[s("th",{scope:"col",class:"px-6 py-3"}," MARKET "),s("th",{scope:"col",class:"px-6 py-3"}," DERECTION "),s("th",{scope:"col",class:"px-6 py-3"}," SIZE "),s("th",{scope:"col",class:"px-6 py-3"}," OPENING "),s("th",{scope:"col",class:"px-6 py-3"}," LAST "),s("th",{scope:"col",class:"px-6 py-3"}," STOP "),s("th",{scope:"col",class:"px-6 py-3"}," LIMIT "),s("th",{scope:"col",class:"px-6 py-3"},"Created at")])],-1),hs={scope:"row",class:"px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap"},_s={class:"px-6 py-4"},xs={class:"px-6 py-4"},gs={class:"px-6 py-4"},us={class:"px-6 py-4"},bs={class:"px-6 py-4"},ys={class:"px-6 py-4"},ms={class:"px-6 py-4"},ks={__name:"Dashboard",setup(ws){function r(a){return a=="USD"?"$":a=="EUR"?"\u20AC":a=="GBP"?"\xA3":a}const h=n({});async function b(){var a=await axios.get(route("dashboard.ig.accounts"));h.value=a.data}const _=n({});async function y(a){var d=await axios.get(route("dashboard.ig.history",a));_.value=d.data}const x=n({});async function m(a){var d=await axios.get(route("dashboard.ig.history",a));x.value=d.data}return b(),y("workingorders"),m("positions"),(a,d)=>(o(),c(i,null,[g(f(v),{title:"Dashboard"}),g(w,null,{header:u(()=>[k]),default:u(()=>[s("div",O,[s("div",D,[s("div",E,[(o(!0),c(i,null,p(h.value.accounts,t=>(o(),c("div",{key:t.accountId},[s("div",L,[s("p",T,[s("small",I,[N,s("b",S,e(t.status),1)])]),s("div",P,[s("div",null,[A,R,s("b",null,e(t.accountId),1)]),s("div",null,[C,s("b",null,e(t.accountName),1)])]),s("div",M,[s("div",B,[G,l(" "+e(r(t.currency))+e(t.balance.available),1)]),s("div",V,[W,l(" "+e(r(t.currency))+e(t.balance.balance),1)]),s("div",z,[F,l(" "+e(r(t.currency))+e(t.balance.deposit),1)]),s("div",H,[K,l(" "+e(r(t.currency))+e(t.balance.profitLoss),1)])])])]))),128))])]),s("div",U,[s("div",Z,[s("div",$,[j,s("table",q,[Y,s("tbody",null,[(o(!0),c(i,null,p(_.value.workingOrders,t=>(o(),c("tr",{key:t.id,class:"dark:hover:text-white bg-white border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-slate-700/50"},[s("th",J,e(t.marketData.instrumentName),1),s("td",Q,e(t.workingOrderData.direction),1),s("td",X,e(t.workingOrderData.size),1),s("td",ss,e(t.workingOrderData.level),1),s("td",ts,e(t.marketData.offer),1),s("td",es,e(t.workingOrderData.contingentStop),1),s("td",as,e(t.workingOrderData.contingentLimit),1),s("td",os,e(t.workingOrderData.requestType),1),s("td",cs,e(t.workingOrderData.goodTill),1),s("td",ls,e(t.workingOrderData.createdDate),1)]))),128))])])])]),s("div",rs,[s("div",ds,[is,s("table",ns,[ps,s("tbody",null,[(o(!0),c(i,null,p(x.value.positions,t=>(o(),c("tr",{key:t.id,class:"dark:hover:text-white bg-white border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-slate-700/50"},[s("th",hs,e(t.market.instrumentName),1),s("td",_s,e(t.position.direction),1),s("td",xs,e(t.position.dealSize),1),s("td",gs,e(t.position.openLevel),1),s("td",us,e(t.market.offer),1),s("td",bs,e(t.position.stopLevel),1),s("td",ys,e(t.position.limitLevel),1),s("td",ms,e(t.position.createdDate),1)]))),128))])])])])])])]),_:1})],64))}};export{ks as default};
