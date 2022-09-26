import{C as u,o as c,D as n,b as i,u as o,e as d,F as b,H as f,E as t,h as x,w as l,B as g,t as m,f as _,R as y,O as v,Q as w}from"./app.f0d0c9cb.js";import{_ as k}from"./AuthenticatedLayout.d664b821.js";const E=t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Edit Filter ",-1),T={class:"py-12"},V={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},F={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},M={class:"p-6 bg-white border-b border-gray-200"},S=["onSubmit"],B={class:"mb-4"},C=t("label",{class:"block text-gray-700 text-sm font-bold mb-2",for:"match_case"}," Match case ",-1),D={key:0,class:"text-red-500 text-sm"},U={class:"w-full mb-6 md:mb-0"},j=t("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-state"}," Type of the filter ",-1),N={class:"relative"},O=t("option",{value:"trade"},"Trade filter",-1),H=t("option",{value:"money-management"},"Trade management (percentage of the trade from balance)",-1),I=t("option",{value:"entry"},"Entry",-1),L=t("option",{value:"stop-loss"},"Stop Loss",-1),P=t("option",{value:"take-profit"},"Take Profit",-1),Q=[O,H,I,L,P],R={key:0,class:"text-red-500 text-sm"},$={class:"md:flex md:items-center mb-6 mt-3"},q={class:"md:w-2/3 block text-gray-500 font-bold"},z=t("span",{class:"text-sm"}," Exact match? ",-1),A=t("div",{class:"flex items-center justify-between mt-3"},[t("button",{class:"bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline",type:"submit"}," Update ")],-1),W={__name:"EditTrading",props:{filter:Object,errors:Object},setup(p){const e=p,s=u({match_case:e.filter.match_case,exact_match:e.filter.exact_match,type:e.filter.type});function h(){w.Inertia.put(route("filters.update",e.filter.id),s)}return(G,a)=>(c(),n(b,null,[i(o(f),{title:"Dashboard"}),i(k,null,{header:d(()=>[E]),default:d(()=>[t("div",T,[t("div",V,[t("div",F,[t("div",M,[t("form",{onSubmit:x(h,["prevent"]),class:"px-8 pt-6 pb-8 mb-4"},[t("div",B,[C,l(t("input",{class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline",id:"match_case",name:"match_case",type:"text","onUpdate:modelValue":a[0]||(a[0]=r=>o(s).match_case=r),placeholder:"Filter word"},null,512),[[g,o(s).match_case]]),e.errors.match_case?(c(),n("span",D,m(e.errors.match_case),1)):_("",!0)]),t("div",U,[j,t("div",N,[l(t("select",{class:"block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500",id:"type",name:"type","onUpdate:modelValue":a[1]||(a[1]=r=>o(s).type=r)},Q,512),[[y,o(s).type]])]),e.errors.type?(c(),n("span",R,m(e.errors.type),1)):_("",!0)]),t("div",$,[t("label",q,[l(t("input",{class:"mr-2 leading-tight",type:"checkbox",id:"exact_match",name:"exact_match","onUpdate:modelValue":a[2]||(a[2]=r=>o(s).exact_match=r)},null,512),[[v,o(s).exact_match]]),z])]),A],40,S)])])])])]),_:1})],64))}};export{W as default};