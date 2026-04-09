import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';

/* =============================
   INIT SEMUA SETELAH DOM READY
============================= */
document.addEventListener("DOMContentLoaded", function () {

    initSidebar();
    initSubmenu();
    initActiveMenu();
    initThreeJS(); // 🔥 3D dipanggil di sini

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
                document.querySelectorAll(".submenu").forEach(el => el.classList.remove("open"));
                document.querySelectorAll(".arrow-icon").forEach(el => el.classList.remove("rotate"));
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

    document.querySelectorAll('.step').forEach(el => el.style.display = 'none');

    const target = document.getElementById('step' + step);
    if (target) target.style.display = 'block';

    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
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
   6. THREE JS (3D MODEL)
============================= */
function initThreeJS() {

    const container = document.getElementById('model3d');

    if (!container) return; // 🔥 biar tidak error di halaman lain

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
    container.appendChild(renderer.domElement);

    // Lighting
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(5, 5, 5);
    scene.add(light);

    const ambient = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambient);

    // Load Model
    const loader = new GLTFLoader();
    loader.load(
        '/models/model-jaringan.glb',
        function (gltf) {
            scene.add(gltf.scene);
        },
        undefined,
        function (error) {
            console.error('Error loading model:', error);
        }
    );

    camera.position.z = 5;

    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }

    animate();
}
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls';

/* =============================
   INIT SEMUA
============================= */
document.addEventListener("DOMContentLoaded", function () {
    initThreeJS();
});

/* =============================
   THREE JS
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

    // 🔥 CONTROL (bisa diputar pakai mouse)
    const controls = new OrbitControls(camera, renderer.domElement);

    // LIGHTING
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(5, 5, 5);
    scene.add(light);

    const ambient = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambient);

    // LOAD MODEL
    const loader = new GLTFLoader();
    loader.load(
        '/models/melati.glb',
        function (gltf) {

            const model = gltf.scene;

            // 🔥 BIAR MODEL TERLIHAT JELAS
            model.scale.set(1, 1, 1);
            model.position.set(0, 0, 0);

            scene.add(model);
        },
        undefined,
        function (error) {
            console.error('Gagal load model:', error);
        }
    );

    camera.position.set(0, 1, 5);

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();

    // 🔥 RESPONSIVE
    window.addEventListener('resize', function () {
        camera.aspect = container.clientWidth / 400;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, 400);
    });
}