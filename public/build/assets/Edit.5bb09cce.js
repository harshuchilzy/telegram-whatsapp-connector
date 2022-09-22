import{s as u,o as c,c as n,a as l,u as o,w as d,F as b,H as f,b as t,x,i,A as y,t as m,m as p,C as g,y as v,B as w}from"./app.7804b47c.js";import{_ as k}from"./AuthenticatedLayout.297affe8.js";import"./ApplicationLogo.aa24a0ee.js";const V=t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Edit Filter ",-1),C={class:"py-12"},E={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},F={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},M={class:"p-6 bg-white border-b border-gray-200"},S=["onSubmit"],T={class:"mb-4"},B=t("label",{class:"block text-gray-700 text-sm font-bold mb-2",for:"match_case"}," Match case ",-1),U={key:0,class:"text-red-500 text-sm"},j={class:"w-full mb-6 md:mb-0"},D=t("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-state"}," Type of the filter ",-1),N={class:"relative"},H=t("option",{value:"trade"},"Trade filter",-1),O=t("option",{value:"money-management"},"Trade management (percentage of the trade from balance)",-1),A=t("option",{value:"entry"},"Entry",-1),I=t("option",{value:"stop-loss"},"Stop Loss",-1),L=t("option",{value:"take-profit"},"Take Profit",-1),P=t("option",{value:"currency"},"Currency pair",-1),$=[H,O,A,I,L,P],q={key:0,class:"text-red-500 text-sm"},z={class:"md:flex md:items-center mb-6"},G={class:"md:w-2/3 block text-gray-500 font-bold"},J=t("span",{class:"text-sm"}," Exact match? ",-1),K=t("div",{class:"flex items-center justify-between mt-3"},[t("button",{class:"bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline",type:"submit"}," Update ")],-1),Y={__name:"Edit",props:{filter:Object,errors:Object},setup(_){const e=_,s=u({match_case:e.filter.match_case,exact_match:e.filter.exact_match,type:e.filter.type});function h(){w.Inertia.put(route("filters.update",e.filter.id),s)}return(Q,a)=>(c(),n(b,null,[l(o(f),{title:"Dashboard"}),l(k,null,{header:d(()=>[V]),default:d(()=>[t("div",C,[t("div",E,[t("div",F,[t("div",M,[t("form",{onSubmit:x(h,["prevent"]),class:"px-8 pt-6 pb-8 mb-4"},[t("div",T,[B,i(t("input",{class:"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline",id:"match_case",name:"match_case",type:"text","onUpdate:modelValue":a[0]||(a[0]=r=>o(s).match_case=r),placeholder:"Filter word"},null,512),[[y,o(s).match_case]]),e.errors.match_case?(c(),n("span",U,m(e.errors.match_case),1)):p("",!0)]),t("div",j,[D,t("div",N,[i(t("select",{class:"block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500",id:"type",name:"type","onUpdate:modelValue":a[1]||(a[1]=r=>o(s).type=r)},$,512),[[g,o(s).type]])]),e.errors.type?(c(),n("span",q,m(e.errors.type),1)):p("",!0)]),t("div",z,[t("label",G,[i(t("input",{class:"mr-2 leading-tight",type:"checkbox",id:"exact_match",name:"exact_match","onUpdate:modelValue":a[2]||(a[2]=r=>o(s).exact_match=r)},null,512),[[v,o(s).exact_match]]),J])]),K],40,S)])])])])]),_:1})],64))}};export{Y as default};