// let currentPage = 1;
// let perPage = 5;

// function renderNotes(data) {
//     let tbody = document.getElementById("notesTable");
//     tbody.innerHTML = "";

//     if (!data.success || !data.notes || data.notes.length === 0) {
//         tbody.innerHTML = "<tr><td colspan='4'>No notes found</td></tr>";
//         document.getElementById("pagination").innerHTML = "";
//         return;
//     }

//     data.notes.forEach(note => {
//         let tr = document.createElement("tr");
//         tr.innerHTML = `
//             <td>${escapeHtml(note.title)}</td>
//             <td>${escapeHtml(note.content)}</td>
//             <td>${escapeHtml(note.created_at)}</td>
//             <td>
//                 <button class="btn btn-sm btn-warning me-1" onclick="openEdit(${note.id})">Edit</button>
//                 <button class="btn btn-sm btn-danger" onclick="deleteNote(${note.id})">Delete</button>
//             </td>
//         `;
//         tbody.appendChild(tr);
//     });

//     buildPagination(data.totalPages, data.currentPage);
// }

// function buildPagination(totalPages, page) {
//     let pagination = document.getElementById("pagination");
//     pagination.innerHTML = "";

//     const delta = 2;
//     let range = [];
//     let rangeWithDots = [];
//     let l;

//     for (let i = 1; i <= totalPages; i++) {
//         if (i === 1 || i === totalPages || (i >= page - delta && i <= page + delta)) {
//             range.push(i);
//         }
//     }

//     for (let i of range) {
//         if (l) {
//             if (i - l === 2) {
//                 rangeWithDots.push(l + 1);
//             } else if (i - l !== 1) {
//                 rangeWithDots.push("...");
//             }
//         }
//         rangeWithDots.push(i);
//         l = i;
//     }

//     if (page > 1) {
//         pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadNotes(${page - 1})">Prev</a></li>`;
//     }

//     for (let i of rangeWithDots) {
//         if (i === "...") {
//             pagination.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
//         } else {
//             let active = (i === page) ? "active" : "";
//             pagination.innerHTML += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="loadNotes(${i})">${i}</a></li>`;
//         }
//     }

//     if (page < totalPages) {
//         pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="loadNotes(${page + 1})">Next</a></li>`;
//     }
// }

// async function loadNotes(page) {
//     currentPage = page;
//     document.getElementById("notesTable").innerHTML = "<tr><td colspan='4'>Loading...</td></tr>";
//     try {
//         let data = await fetchNotesAjax(page, perPage);
//         renderNotes(data);
//     } catch (err) {
//         document.getElementById("notesTable").innerHTML = "<tr><td colspan='4'>Error loading notes</td></tr>";
//     }
// }

// async function deleteNote(id) {
//     if (!confirm("Are you sure?")) return;
//     try {
//         let data = await deleteNoteRequest(id);
//         if (data.success) loadNotes(currentPage);
//         else alert("Delete failed");
//     } catch {
//         alert("Network error");
//     }
// }

// async function openEdit(id) {
//     try {
//         const res = await fetch(`${NOTES_AJAX}/edit?id=${id}`);
//         const data = await res.json();
//         if (!data.success) {
//             alert("Failed to load note");
//             return;
//         }

//         const modalEl = document.getElementById("noteModal");
//         modalEl.querySelector(".modal-title").textContent = "Edit Note";
//         let body = modalEl.querySelector(".modal-body");
//         body.innerHTML = document.querySelector('#__tpl_edit') ? document.querySelector('#__tpl_edit').innerHTML : '';
//         const form = body.querySelector('form');
//         form.dataset.id = id;
//         form.querySelector('[name=title]').value = data.note.title;
//         form.querySelector('[name=content]').value = data.note.content;

//         const modal = new bootstrap.Modal(modalEl);
//         modal.show();

//         form.addEventListener("submit", async function (e) {
//             e.preventDefault();
//             const fd = new FormData(form);
//             const response = await submitFormToAjax(`${NOTES_AJAX}/edit?id=${id}`, fd);
//             if (response.trim().toLowerCase() === "ok") {
//                 modal.hide();
//                 loadNotes(currentPage);
//             } else {
//                 body.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger">${escapeHtml(response)}</div>`);
//             }
//         }, { once: true });

//     } catch (err) {
//         alert("Error loading edit form");
//     }
// }

// document.addEventListener('DOMContentLoaded', function () {
//     document.getElementById("addBtn").addEventListener("click", () => {
//         openForm();
//     });
//     loadNotes(1);
// });

// async function openForm() {
//     const modalEl = document.getElementById("noteModal");
//     modalEl.querySelector(".modal-title").textContent = "Add Note";
//     let body = modalEl.querySelector(".modal-body");
//     body.innerHTML = document.querySelector('#__tpl_create') ? document.querySelector('#__tpl_create').innerHTML : '';
//     const form = body.querySelector('form');

//     const modal = new bootstrap.Modal(modalEl);
//     modal.show();

//     form.addEventListener("submit", async function (e) {
//         e.preventDefault();
//         const fd = new FormData(form);
//         const response = await submitFormToAjax(`${NOTES_AJAX}/create`, fd);
//         if (response.trim().toLowerCase() === "ok") {
//             modal.hide();
//             loadNotes(currentPage);
//         } else {
//             body.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger">${escapeHtml(response)}</div>`);
//         }
//     }, { once: true });
// }

// function escapeHtml(unsafe) {
//     if (unsafe === null || unsafe === undefined) return '';
//     return String(unsafe)
//         .replace(/&/g, '&amp;')
//         .replace(/</g, '&lt;')
//         .replace(/>/g, '&gt;')
//         .replace(/"/g, '&quot;')
//         .replace(/'/g, '&#039;');
// }
