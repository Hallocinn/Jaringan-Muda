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
    initTableSiswa();
});


/* =============================
   1. SIDEBAR
============================= */
function initSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleBtn");

    if (!toggleBtn || !sidebar) return;

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


/* =============================
   2. SUBMENU
============================= */
function initSubmenu() {
    const sidebar = document.getElementById("sidebar");
    const submenuToggles = document.querySelectorAll(".submenu-toggle");

    if (!sidebar) return;

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

    if (!activeSubLink) return;

    const parentSubmenu = activeSubLink.closest(".submenu");
    if (!parentSubmenu) return;

    const parentBtn = parentSubmenu.previousElementSibling;

    parentSubmenu.classList.add("open");

    if (parentBtn) {
        const arrow = parentBtn.querySelector(".arrow-icon");
        if (arrow) arrow.classList.add("rotate");
    }
}


/* =============================
   4. PROGRESS MATERI
============================= */
window.completedSteps = new Set();

window.showStep = function (step, btn) {
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
window.toggleReaction = function (btn) {
    const icon = btn.querySelector('i');
    const span = btn.querySelector('.count') || btn.querySelector('span');

    if (!icon || !span) return;

    let count = parseInt(span.innerText) || 0;

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
   6. THREE JS - MODEL 3D DINAMIS + CAROUSEL
============================= */
const threeViewers = [];

function initThreeJS() {
    const containers = document.querySelectorAll('[data-model], [data-models]');

    if (!containers.length) return;

    containers.forEach(container => {
        buatViewer3D(container);
    });
}

function buatViewer3D(container) {
    let modelList = [];

    if (container.dataset.models) {
        try {
            modelList = JSON.parse(container.dataset.models);
        } catch (error) {
            console.error("Format data-models salah:", error);
            return;
        }
    } else if (container.dataset.model) {
        modelList = [
            {
                src: container.dataset.model,
                caption: container.dataset.caption || ''
            }
        ];
    }

    if (!modelList.length) {
        console.error("Model 3D belum diatur. Gunakan data-model atau data-models.");
        return;
    }

    container.innerHTML = '';

    const section = container.closest('.model-section');
    const captionEl = section ? section.querySelector('[data-model-caption]') : null;
    const currentEl = section ? section.querySelector('[data-model-current]') : null;
    const totalEl = section ? section.querySelector('[data-model-total]') : null;
    const prevBtn = section ? section.querySelector('[data-model-prev]') : null;
    const nextBtn = section ? section.querySelector('[data-model-next]') : null;

    let currentIndex = 0;
    let activeModel = null;

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x0f172a);

    const width = container.clientWidth || 800;
    const height = container.clientHeight || 420;

    const camera = new THREE.PerspectiveCamera(
        45,
        width / height,
        0.1,
        1000
    );

    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: false
    });

    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x0f172a, 1);

    renderer.domElement.style.width = '100%';
    renderer.domElement.style.height = '100%';
    renderer.domElement.style.display = 'block';
    renderer.domElement.style.background = '#0f172a';

    container.appendChild(renderer.domElement);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.enableZoom = true;
    controls.enableRotate = true;
    controls.enablePan = true;

    const ambient = new THREE.AmbientLight(0xffffff, 1.2);
    scene.add(ambient);

    const light1 = new THREE.DirectionalLight(0xffffff, 1.5);
    light1.position.set(5, 8, 5);
    scene.add(light1);

    const light2 = new THREE.DirectionalLight(0xffffff, 0.8);
    light2.position.set(-5, 4, -5);
    scene.add(light2);

    const loader = new GLTFLoader();

    function updateInfo() {
        if (captionEl) {
            captionEl.innerText = modelList[currentIndex].caption || '';
        }

        if (currentEl) {
            currentEl.innerText = currentIndex + 1;
        }

        if (totalEl) {
            totalEl.innerText = modelList.length;
        }

        if (prevBtn) {
            prevBtn.style.visibility = modelList.length > 1 ? 'visible' : 'hidden';
        }

        if (nextBtn) {
            nextBtn.style.visibility = modelList.length > 1 ? 'visible' : 'hidden';
        }
    }

    function hapusModelLama() {
        if (!activeModel) return;

        scene.remove(activeModel);

        activeModel.traverse(object => {
            if (object.geometry) {
                object.geometry.dispose();
            }

            if (object.material) {
                if (Array.isArray(object.material)) {
                    object.material.forEach(material => material.dispose());
                } else {
                    object.material.dispose();
                }
            }
        });

        activeModel = null;
    }

    function loadModel(index) {
        currentIndex = index;

        if (currentIndex < 0) {
            currentIndex = modelList.length - 1;
        }

        if (currentIndex >= modelList.length) {
            currentIndex = 0;
        }

        updateInfo();
        hapusModelLama();

        const modelUrl = modelList[currentIndex].src;

        loader.load(

            modelUrl,

            function (gltf) {
                activeModel = gltf.scene;
                scene.add(activeModel);

                pusatkanModel(activeModel, camera, controls);

                console.log("Model berhasil dimuat:", modelUrl);
            },

            function (xhr) {
                if (xhr.total) {
                    const progress = (xhr.loaded / xhr.total * 100).toFixed(0);
                    console.log(`Loading ${modelUrl}: ${progress}%`);
                }
            },

            function (error) {
                console.error("Model gagal dimuat:", modelUrl, error);

                if (captionEl) {
                    captionEl.innerText = "Model gagal dimuat. Periksa nama file dan lokasi di folder public/models.";
                }
            }
        );
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            loadModel(currentIndex - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            loadModel(currentIndex + 1);
        });
    }

    function resizeRenderer() {
        const w = container.clientWidth || window.innerWidth;
        const h = container.clientHeight || window.innerHeight;

        camera.aspect = w / h;
        camera.updateProjectionMatrix();

        renderer.setSize(w, h);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    }

    threeViewers.push({
        container,
        renderer,
        camera,
        resizeRenderer
    });

    window.addEventListener('resize', resizeRenderer);

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();

    loadModel(0);
}


/* =============================
   7. PUSATKAN MODEL OTOMATIS
============================= */
function pusatkanModel(model, camera, controls) {
    const box = new THREE.Box3().setFromObject(model);
    const center = box.getCenter(new THREE.Vector3());
    const size = box.getSize(new THREE.Vector3());

    model.position.x -= center.x;
    model.position.y -= center.y;
    model.position.z -= center.z;

    const newBox = new THREE.Box3().setFromObject(model);
    const newSize = newBox.getSize(new THREE.Vector3());

    const maxDim = Math.max(newSize.x, newSize.y, newSize.z);
    const fov = camera.fov * (Math.PI / 180);

    let cameraZ = Math.abs(maxDim / 2 / Math.tan(fov / 2));
    cameraZ *= 2.2;

    camera.position.set(0, maxDim * 0.15, cameraZ);
    camera.near = cameraZ / 100;
    camera.far = cameraZ * 100;
    camera.updateProjectionMatrix();

    controls.target.set(0, 0, 0);
    controls.update();
}


/* =============================
   8. FULLSCREEN MODEL 3D
============================= */
window.toggleFullscreen = function (button) {
    const section = button.closest('.model-section');
    const btnText = button;

    if (!section || !btnText) return;

    if (!document.fullscreenElement) {
        if (section.requestFullscreen) {
            section.requestFullscreen();
        } else if (section.webkitRequestFullscreen) {
            section.webkitRequestFullscreen();
        }

        btnText.innerHTML = '<i class="fas fa-compress"></i> Perkecil Layar';
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }

        btnText.innerHTML = '<i class="fas fa-expand"></i> Layar Penuh';
    }

    setTimeout(refreshSemuaViewer3D, 300);
};

document.addEventListener('fullscreenchange', function () {
    const btnText = document.querySelector('#fullscreenBtn');

    if (btnText) {
        if (document.fullscreenElement) {
            btnText.innerHTML = '<i class="fas fa-compress"></i> Perkecil Layar';
        } else {
            btnText.innerHTML = '<i class="fas fa-expand"></i> Layar Penuh';
        }
    }

    setTimeout(refreshSemuaViewer3D, 300);
});

document.addEventListener('webkitfullscreenchange', function () {
    setTimeout(refreshSemuaViewer3D, 300);
});

function refreshSemuaViewer3D() {
    threeViewers.forEach(viewer => {
        viewer.resizeRenderer();
    });
}


/* =============================
   9. DATA SISWA
============================= */
let dataSiswa = [
    { nama: "Andi", kelas: "X IPA", nilai: 80 },
    { nama: "Budi", kelas: "XI IPA", nilai: 75 },
];

let editIndex = null;

function initTableSiswa() {
    const tabel = document.querySelector("#tabelSiswa tbody");
    const filterKelas = document.getElementById("filterKelas");

    if (!tabel || !filterKelas) return;

    renderTable();

    filterKelas.addEventListener("change", renderTable);
}

window.renderTable = function () {
    const tbody = document.querySelector("#tabelSiswa tbody");
    const filterInput = document.getElementById("filterKelas");

    if (!tbody || !filterInput) return;

    const filter = filterInput.value;

    tbody.innerHTML = "";

    dataSiswa.forEach((siswa, i) => {
        if (filter && siswa.kelas !== filter) return;

        tbody.innerHTML += `
            <tr>
                <td>${siswa.nama}</td>
                <td>${siswa.kelas}</td>
                <td>${siswa.nilai}</td>
                <td>
                    <button class="btn btn-success" onclick="editData(${i})">Edit</button>
                    <button class="btn btn-danger" onclick="hapusData(${i})">Hapus</button>
                </td>
            </tr>
        `;
    });
};


/* =============================
   10. MODAL DATA SISWA
============================= */
window.openForm = function () {
    const modal = document.getElementById("modalForm");
    const formTitle = document.getElementById("formTitle");
    const nama = document.getElementById("nama");
    const kelas = document.getElementById("kelas");
    const nilai = document.getElementById("nilai");

    if (!modal || !formTitle || !nama || !kelas || !nilai) return;

    modal.style.display = "flex";
    formTitle.innerText = "Tambah Siswa";
    nama.value = "";
    kelas.value = "";
    nilai.value = "";
    editIndex = null;
};

window.tutupForm = function () {
    const modal = document.getElementById("modalForm");
    if (modal) modal.style.display = "none";
};

window.simpanData = function () {
    const namaInput = document.getElementById("nama");
    const kelasInput = document.getElementById("kelas");
    const nilaiInput = document.getElementById("nilai");

    if (!namaInput || !kelasInput || !nilaiInput) return;

    const nama = namaInput.value;
    const kelas = kelasInput.value;
    const nilai = nilaiInput.value;

    if (!nama || !kelas || !nilai) {
        alert("Isi semua!");
        return;
    }

    if (editIndex !== null) {
        dataSiswa[editIndex] = { nama, kelas, nilai };
    } else {
        dataSiswa.push({ nama, kelas, nilai });
    }

    window.tutupForm();
    window.renderTable();
};

window.editData = function (i) {
    const siswa = dataSiswa[i];

    const modal = document.getElementById("modalForm");
    const formTitle = document.getElementById("formTitle");
    const nama = document.getElementById("nama");
    const kelas = document.getElementById("kelas");
    const nilai = document.getElementById("nilai");

    if (!siswa || !modal || !formTitle || !nama || !kelas || !nilai) return;

    modal.style.display = "flex";

    formTitle.innerText = "Edit Siswa";
    nama.value = siswa.nama;
    kelas.value = siswa.kelas;
    nilai.value = siswa.nilai;

    editIndex = i;
};

window.hapusData = function (i) {
    if (confirm("Hapus data?")) {
        dataSiswa.splice(i, 1);
        window.renderTable();
    }
};