// async function fetchNotesAjax(page, perPage = 5) {
//     const url = `${NOTES_AJAX}/load?page=${page}&perPage=${perPage}`;

//     try {
//         const response = await fetch(url, { credentials: 'same-origin' });

//         if (!response.ok) {
//             console.log('error')
//             throw new Error(`Request failed: ${response.status} ${response.statusText}`);
//         }

//         return await response.json();
//     } catch (error) {
//         throw error;
//     }
// }

// async function deleteNoteRequest(id) {
//     const res = await fetch(`${NOTES_AJAX}/delete`, {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         body: `id=${encodeURIComponent(id)}`,
//         credentials: 'same-origin'
//     });
//     return res.json();
// }

// async function fetchFormHtml(viewName, id = null) {
//     if (viewName === 'create') {
//         return await (new Promise(resolve => {
//             resolve(document.querySelector('#__tpl_create') ? document.querySelector('#__tpl_create').innerHTML : '');
//         }));
//     }
//     if (viewName === 'edit') {
//         return await (new Promise(resolve => {
//             resolve(document.querySelector('#__tpl_edit') ? document.querySelector('#__tpl_edit').innerHTML : '');
//         }));
//     }
//     return '';
// }

// async function submitFormToAjax(actionUrl, formData) {
//     const res = await fetch(actionUrl, {
//         method: 'POST',
//         body: formData,
//         credentials: 'same-origin'
//     });
//     return res.json();
// }
