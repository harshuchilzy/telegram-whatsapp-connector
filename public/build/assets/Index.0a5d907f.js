import{o as a,c as o,a as d,u as n,w as r,F as c,H as p,b as t,r as i,t as e}from"./app.7804b47c.js";import{_}from"./AuthenticatedLayout.297affe8.js";import"./ApplicationLogo.aa24a0ee.js";const h=t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Meassages ",-1),x={class:"py-12"},b={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},y={class:"overflow-hidden shadow-sm sm:rounded-lg"},g={class:"grid grid-cols-10 gap-4"},u={class:"p-6 bg-white border-b border-gray-200 col-span-5"},m=t("h1",{class:"mb-4"},"Accepted",-1),k={class:"table w-full text-sm text-left text-gray-500 dark:text-gray-400",id:"datatable_1"},w=t("thead",{class:"text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white"},[t("tr",null,[t("th",{scope:"col",class:"px-6 py-3"}," Derections "),t("th",{scope:"col",class:"px-6 py-3"}," Sender "),t("th",{scope:"col",class:"px-6 py-3"}," Message "),t("th",{scope:"col",class:"px-6 py-3"}," Action ")])],-1),f={scope:"row",class:"px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap"},v={class:"px-6 py-4"},D={class:"px-6 py-4"},j={class:"px-6 py-4"},A={class:"p-6 bg-white border-b border-gray-200 col-span-5"},B=t("h1",{class:"mb-4"},"Rejected",-1),M={class:"table w-full text-sm text-left text-gray-500 dark:text-gray-400",id:"datatable_1"},S=t("thead",{class:"text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white"},[t("tr",null,[t("th",{scope:"col",class:"px-6 py-3"}," Derections "),t("th",{scope:"col",class:"px-6 py-3"}," Sender "),t("th",{scope:"col",class:"px-6 py-3"}," Message "),t("th",{scope:"col",class:"px-6 py-3"}," Action ")])],-1),F={scope:"row",class:"px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap"},H={class:"px-6 py-4"},N={class:"px-6 py-4"},O={class:"px-6 py-4"},R={__name:"Index",props:{messages:Object,accepted:Object},setup(l){return(V,C)=>(a(),o(c,null,[d(n(p),{title:"Dashboard"}),d(_,null,{header:r(()=>[h]),default:r(()=>[t("div",x,[t("div",b,[t("div",y,[t("div",g,[t("div",u,[m,t("table",k,[w,t("tbody",null,[(a(!0),o(c,null,i(l.accepted,s=>(a(),o("tr",{key:s.id,class:"bg-white border-b border-gray-100 text-black"},[t("th",f,e(s.direction),1),t("td",v,e(s.sender),1),t("td",D,e(s.message),1),t("td",j,e(s.action),1)]))),128))])])]),t("div",A,[B,t("table",M,[S,t("tbody",null,[(a(!0),o(c,null,i(l.messages,s=>(a(),o("tr",{key:s.id,class:"bg-white border-b border-gray-100 text-black"},[t("th",F,e(s.direction),1),t("td",H,e(s.sender),1),t("td",N,e(s.message),1),t("td",O,e(s.action),1)]))),128))])])])])])])])]),_:1})],64))}};export{R as default};