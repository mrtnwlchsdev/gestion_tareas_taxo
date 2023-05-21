import { defineStore } from "pinia";

export const useTasksStore = defineStore("tasksStore", {
    state: () => ({
        tasks: [],
        regex: /^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]+$/,
        user_id: 0,
    }),
    getters: {
        getTasks: (state) => state.tasks,
        getRegex: (state) => state.regex,
        getUserId: (state) => state.user_id,
    },
    actions: {
        setUserId(param) {
            this.user_id = param;
        },
        setTasks(param) {
            this.tasks = param;
        },
        deleteTask(param) {
            this.tasks = this.tasks.filter((task) => task.id !== param);
        },
        updateTasks(description, title, id) {
            this.tasks = this.tasks.map((task) => {
                if (task.id === id) {
                    task = {
                        ...task,
                        task_title: title,
                        task_description: description,
                    };
                }
                return task;
            });
        },
    },
});
