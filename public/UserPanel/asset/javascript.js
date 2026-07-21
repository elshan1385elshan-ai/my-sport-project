//============================
// Sidebar Toggle
//============================

const menuBtn = document.getElementById("menuBtn");
const sidebar = document.querySelector(".sidebar");

menuBtn.addEventListener("click", ()=>{

    if(window.innerWidth <= 900){

        sidebar.classList.toggle("show");

    }else{

        sidebar.classList.toggle("close");

    }

});

//============================
// Active Menu
//============================

const menuItems = document.querySelectorAll(".sidebar a");

menuItems.forEach(item=>{

    item.addEventListener("click",()=>{

        menuItems.forEach(i=>i.classList.remove("active"));

        item.classList.add("active");

    });

});

//============================
// Close sidebar on mobile
//============================

window.addEventListener("click",(e)=>{

    if(window.innerWidth <=900){

        if(
            !sidebar.contains(e.target) &&
            !menuBtn.contains(e.target)
        ){
            sidebar.classList.remove("show");
        }

    }

});

//============================
// Responsive Fix
//============================

window.addEventListener("resize",()=>{

    if(window.innerWidth >900){

        sidebar.classList.remove("show");

    }

});

//============================
// Current Date
//============================

const today = new Date();

const options = {
    weekday:'long',
    year:'numeric',
    month:'long',
    day:'numeric'
};

console.log(today.toLocaleDateString('fa-IR',options));

//============================
// Card Animation
//============================

const cards=document.querySelectorAll(".card");

cards.forEach((card,index)=>{

    card.style.opacity=0;
    card.style.transform="translateY(40px)";

    setTimeout(()=>{

        card.style.transition=".6s";
        card.style.opacity=1;
        card.style.transform="translateY(0)";

    },index*150);

});