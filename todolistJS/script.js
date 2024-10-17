document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('todo-form');
    const input = document.getElementById('todo-input');
    const todoList = document.getElementById('todo-list');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (input.value.trim()) {
            addTodo(input.value.trim());
            input.value = '';
        }
    });

    function addTodo(text) {
        const li = document.createElement('li');
        li.className = 'todo-item';
        li.innerHTML = `
            <span>${text}</span>
            <div>
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
            </div>
        `;

        li.querySelector('.edit').addEventListener('click', () => editTodo(li));
        li.querySelector('.delete').addEventListener('click', () => deleteTodo(li));

        todoList.appendChild(li);
    }

    function editTodo(li) {
        const span = li.querySelector('span');
        const newText = prompt('Edit your task:', span.textContent);
        if (newText !== null && newText.trim() !== '') {
            span.textContent = newText.trim();
        }
    }

    function deleteTodo(li) {
        li.remove();
    }
});