'use strict'

let welComeTxt = document.querySelector('#welcme');
let tasksList = document.querySelector('.taskList');
let addTaskBtn = document.querySelector('.btnAddTask');
let messageBot = document.querySelector('.congrats');
let loggedUesr = document.querySelector('#userNameHtag').textContent;


let user = {
    userName: loggedUesr,
    tasks: [],
    tasksDone: []
}

const getPass = function () {
    let pass = prompt("Password:");

}

const updateUI = function (userLogged) {
    tasksList.innerHTML = "";
    welComeTxt.innerHTML = `welcome ${user.userName}, wish you a good day!`;
    for (let i = userLogged.tasks.length - 1; i > -1; i--) {
        let html = `
        <div class="task">
                <div class="taskContainer">
                    <p class="task_name">${userLogged.tasks[i]}</p>
                </div>
                <input type="checkbox" class="task_checkBox" id="c${i}" onchange="checkboxFun(user, this)">
                
                    <button class="task_remove" id="r${i}" onclick="removeTaskFun(user, this)"></button>
            </div>
        `;
        tasksList.insertAdjacentHTML("afterbegin", html);
    }
    const tasksDoneStyle = document.querySelectorAll('.task_name');
    const checkboxes = document.querySelectorAll('.task_checkBox');
    for (let j = 0; j < userLogged.tasksDone.length; j++) {
        if (userLogged.tasksDone[j] == 1) {
            tasksDoneStyle[j].classList.add('lineThrough');
            checkboxes[j].checked = true;
        }
    }
    messageBot.textContent = bottomMessage(user);
}

const addTaskFun = function (userLogged) {
    var newTask = prompt("Task name:", "");
    // فرض کرده شده userLogged.userName و newTask دارای مقادیر مورد نیاز هستند

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // عملیات با موفقیت انجام شد
                console.log('Task added successfully!');
            } else {
                // مشکل در ارسال اطلاعات به addTask.php
                console.error('There was a problem adding the task.');
            }
        }
    };

    // آدرس فایل addTask.php را با دقت وارد کنید
    var url = 'addTask.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // اطلاعاتی که باید به addTask.php ارسال شوند
    var data = 'userName=' + encodeURIComponent(user.userName) + '&task=' + encodeURIComponent(newTask);
    xhr.send(data);


    userLogged.tasks.push(newTask);
    userLogged.tasksDone.push(0);
    updateUI(userLogged);
}

const checkboxFun = function (userLogged, checkboxBtnPressed) {

    let newTasksDoneArr = [];
    let checkboxBtn = document.querySelectorAll('.task_checkBox');
    for (let i = 0; i < checkboxBtn.length; i++) {
        if (checkboxBtn[i].id != checkboxBtnPressed.id) {
            newTasksDoneArr.push(userLogged.tasksDone[i]);
        }
        else {
            newTasksDoneArr.push(!userLogged.tasksDone[i]);
        }
    }
    console.log(newTasksDoneArr);
    userLogged.tasksDone = newTasksDoneArr;
    updateUI(userLogged);

}

const removeTaskFun = function (userLogged, removeTaskBtnPressed) {
    let newTasksArr = [];
    let newTasksDoneArr = [];
    let removeTaskBtn = document.querySelectorAll('.task_remove');
    for (let i = 0; i < removeTaskBtn.length; i++) {
        if (removeTaskBtn[i].id != removeTaskBtnPressed.id) {
            newTasksArr.push(userLogged.tasks[i]);
            newTasksDoneArr.push(userLogged.tasksDone[i]);

        }
    }
    userLogged.tasks = newTasksArr;
    userLogged.tasksDone = newTasksDoneArr;

    updateUI(userLogged);
}

const bottomMessage = function (userLogged) {
    let sum = 0;
    let message;
    userLogged.tasksDone.forEach(element => {
        sum += element;
    });
    if (sum == 0) {
        message = "Don't give up, wake up and start 💪";
    }
    else if (sum < userLogged.tasks.length - 1) {
        message = `Congrats! You've done ${sum} tasks so far 🎉`;
    }
    else if (sum == userLogged.tasks.length - 1) {
        message = "Almost there... 1 more task to do 🫡";
    }
    else if (sum == userLogged.tasks.length) {
        message = "You are the greatest! Don't forget to plan tommorrow 📃";
    }
    return message;
}

const username = user.userName;
var tasksSTR;

fetch('get_tasks.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'username=' + encodeURIComponent(username),
})
    .then(response => response.text())
    .then(data => {
        // اگر داده‌ها با موفقیت دریافت شدند
        tasksSTR = data; // دریافت داده و قرار دادن آن در یک متغیر

        user.tasks = tasksSTR.split(',');

        if (user.tasks[0] == "") {
            user.tasks = [];
        }
        
        console.log(user.tasks);
        updateUI(user);
    })
    .catch((error) => {
        // هندل کردن هر گونه خطا
        console.error('Error:', error);
    });



updateUI(user);




