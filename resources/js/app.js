/* =============================
   IMPORT
============================= */
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls';


/* =============================
   INIT SEMUA SETELAH DOM READY
============================= */
document.addEventListener("DOMContentLoaded", function () {

    initSidebar();
    initSubmenu();
    initActiveMenu();
    initThreeJS();

});


/* =============================
   1. SIDEBAR
============================= */
function initSidebar() {

    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleBtn");

    if (toggleBtn && sidebar) {

        toggleBtn.addEventListener("click", function () {

            sidebar.classList.toggle("collapsed");

            if (sidebar.classList.contains("collapsed")) {

                document.querySelectorAll(".submenu")
                    .forEach(el => el.classList.remove("open"));

                document.querySelectorAll(".arrow-icon")
                    .forEach(el => el.classList.remove("rotate"));
            }

        });

    }

}


/* =============================
   2. SUBMENU
============================= */
function initSubmenu() {

    const sidebar = document.getElementById("sidebar");
    const submenuToggles = document.querySelectorAll(".submenu-toggle");

    submenuToggles.forEach(button => {

        button.addEventListener("click", function (e) {

            e.preventDefault();

            if (sidebar.classList.contains("collapsed")) {
                sidebar.classList.remove("collapsed");
            }

            const submenu = this.nextElementSibling;
            const arrow = this.querySelector(".arrow-icon");

            if (submenu) submenu.classList.toggle("open");
            if (arrow) arrow.classList.toggle("rotate");

        });

    });

}


/* =============================
   3. AUTO ACTIVE MENU
============================= */
function initActiveMenu() {

    const activeSubLink = document.querySelector(".submenu a.active");

    if (activeSubLink) {

        const parentSubmenu = activeSubLink.closest(".submenu");
        const parentBtn = parentSubmenu.previousElementSibling;

        parentSubmenu.classList.add("open");

        if (parentBtn) {

            const arrow = parentBtn.querySelector(".arrow-icon");

            if (arrow) arrow.classList.add("rotate");

        }

    }

}


/* =============================
   4. PROGRESS MATERI
============================= */
window.completedSteps = new Set();

window.showStep = function(step, btn) {

    document.querySelectorAll('.step')
        .forEach(el => el.style.display = 'none');

    const target = document.getElementById('step' + step);

    if (target) target.style.display = 'block';

    document.querySelectorAll('.tab-btn')
        .forEach(el => el.classList.remove('active'));

    if (btn) btn.classList.add('active');

    window.completedSteps.add(step);

    const kuisBtn = document.getElementById('kuisBtn');

    if (kuisBtn && window.completedSteps.size === 5) {

        kuisBtn.disabled = false;
        kuisBtn.innerHTML = "✅ Buka Kuis Sekarang";
        kuisBtn.style.opacity = "1";
        kuisBtn.style.cursor = "pointer";
        kuisBtn.style.background = "#16a34a";
        kuisBtn.style.color = "#fff";

    }

};


/* =============================
   5. REACTION BUTTON
============================= */
window.toggleReaction = function(btn) {

    const icon = btn.querySelector('i');
    const span = btn.querySelector('.count') || btn.querySelector('span');

    let count = parseInt(span.innerText);

    btn.classList.toggle('active');

    if (btn.classList.contains('active')) {

        span.innerText = count + 1;
        icon.classList.replace('fa-regular', 'fa-solid');

    } else {

        span.innerText = count - 1;
        icon.classList.replace('fa-solid', 'fa-regular');

    }

};


/* =============================
   6. THREE JS (MODEL 3D)
============================= */
function initThreeJS() {

    const container = document.getElementById('model3d');

    if (!container) return;

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf0f0f0);


    const camera = new THREE.PerspectiveCamera(
        75,
        container.clientWidth / 400,
        0.1,
        1000
    );


    const renderer = new THREE.WebGLRenderer({ antialias: true });

    renderer.setSize(container.clientWidth, 400);
    renderer.setPixelRatio(window.devicePixelRatio);

    container.appendChild(renderer.domElement);


    /* ===== CONTROL MOUSE ===== */
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;


    /* ===== LIGHT ===== */
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(5,5,5);
    scene.add(light);

    const ambient = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambient);


    /* ===== LOAD MODEL ===== */
    const loader = new GLTFLoader();

    loader.load(

        '/models/melati.glb',

        function (gltf) {

            const model = gltf.scene;

            model.scale.set(1,1,1);
            model.position.set(0,0,0);

            scene.add(model);

        },

        undefined,

        function (error) {

            console.error("Model gagal dimuat:", error);

        }

    );


    camera.position.set(0,1,5);


    /* ===== ANIMATION LOOP ===== */
    function animate() {

        requestAnimationFrame(animate);

        controls.update();
        renderer.render(scene, camera);

    }

    animate();


    /* ===== RESPONSIVE ===== */
    window.addEventListener('resize', function () {

        camera.aspect = container.clientWidth / 500;
        camera.updateProjectionMatrix();

        renderer.setSize(container.clientWidth, 500);

    });

}

let dataSiswa = [
    {nama:"Andi", kelas:"X IPA", nilai:80},
    {nama:"Budi", kelas:"XI IPA", nilai:75},
];

let editIndex = null;

function renderTable(){
    const tbody = document.querySelector("#tabelSiswa tbody");
    const filter = document.getElementById("filterKelas").value;

    tbody.innerHTML = "";

    dataSiswa.forEach((siswa, i)=>{
        if(filter && siswa.kelas !== filter) return;

        tbody.innerHTML += `
        <tr>
            <td>${siswa.nama}</td>
            <td>${siswa.kelas}</td>
            <td>${siswa.nilai}</td>
            <td>
                <button class="btn btn-success" onclick="editData(${i})">Edit</button>
                <button class="btn btn-danger" onclick="hapusData(${i})">Hapus</button>
            </td>
        </tr>`;
    });
}

/* MODAL */
function openForm(){
    document.getElementById("modalForm").style.display="flex";
    document.getElementById("formTitle").innerText="Tambah Siswa";
    document.getElementById("nama").value="";
    document.getElementById("kelas").value="";
    document.getElementById("nilai").value="";
    editIndex=null;
}

function tutupForm(){
    document.getElementById("modalForm").style.display="none";
}

/* SIMPAN */
function simpanData(){
    const nama = document.getElementById("nama").value;
    const kelas = document.getElementById("kelas").value;
    const nilai = document.getElementById("nilai").value;

    if(!nama || !kelas || !nilai) return alert("Isi semua!");

    if(editIndex !== null){
        dataSiswa[editIndex] = {nama, kelas, nilai};
    }else{
        dataSiswa.push({nama, kelas, nilai});
    }

    tutupForm();
    renderTable();
}

/* EDIT */
function editData(i){
    const s = dataSiswa[i];
    document.getElementById("modalForm").style.display="flex";

    document.getElementById("formTitle").innerText="Edit Siswa";
    document.getElementById("nama").value=s.nama;
    document.getElementById("kelas").value=s.kelas;
    document.getElementById("nilai").value=s.nilai;

    editIndex=i;
}

/* HAPUS */
function hapusData(i){
    if(confirm("Hapus data?")){
        dataSiswa.splice(i,1);
        renderTable();
    }
}

/* FILTER */
document.addEventListener("DOMContentLoaded", ()=>{
    renderTable();
    document.getElementById("filterKelas").addEventListener("change", renderTable);
});

