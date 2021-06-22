
var bglist = document.body.firstElementChild.children[1].children[1].firstElementChild.firstElementChild.children[1].lastElementChild.children[1];

bglist.addEventListener('change', (event) => {

    let index = event.target.value.indexOf("-", 0)
    let code = event.target.value.substring(0,index)
    console.log(code)
    document.body.style.backgroundColor = code;

}
)

console.log(bglist);  
