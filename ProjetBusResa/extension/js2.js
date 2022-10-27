let input = document.querySelector("#inp");

let valeurlenght = input.value.length;
let stock;
let caract;
let tf = false;
let voir = document.querySelector(".voir");
voir.addEventListener("click", function(){
    let val = input.value;
    let text = "text";
    let password = "password";

    if(tf == false) {
        input.type = text;
        input.value = val;
        tf = true;
    }else{
        input.type = password;
        tf = false;
    }
})