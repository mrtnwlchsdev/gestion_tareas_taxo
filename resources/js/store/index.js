import { defineStore } from "pinia";

// Funcion comsable utilizada para actualizar las tareas alojadas en el store
import updateTasks from "@/composables/updateTasks";

export const useTasksStore = defineStore("tasksStore", {
    state: () => ({
        tasks: [],
        all_tasks: [],
        regex: /^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]+$/,
        user_id: 0,
    }),
    getters: {
        getTasks: (state) => state.tasks,
        getRegex: (state) => state.regex,
        getUserId: (state) => state.user_id,
        getAllTasks: (state) => state.all_tasks,
    },
    actions: {
        setUserId(param) {
            this.user_id = param;
        },
        setTasks(param) {
            this.tasks = param;
        },
        setAllTasks(param) {
            this.all_tasks = param;
        },
        deleteTask(param) {
            this.tasks = this.tasks.filter((task) => task.id !== param);
        },
        updateTasks(description, title, id) {
            const getTags = updateTasks(this.tasks, description, title, id);
            this.tasks = getTags;
        },
        updateAllTasks(description, title, id) {
            const getTags = updateTasks(this.all_tasks, description, title, id);
            this.all_tasks = getTags;
        },
        updateFavorite(param) {
            this.tasks = this.tasks.map((task) => {
                if (task.id === param) {
                    task = {
                        ...task,
                        favorite_task: task.favorite_task === 0 ? 1 : 0,
                    };
                }
                return task;
            });
        },
        updateFavoriteAll(param) {
            this.all_tasks = this.all_tasks.map((task) => {
                if (task.id === param) {
                    task = {
                        ...task,
                        favorite_task: task.favorite_task === 0 ? 1 : 0,
                    };
                }
                return task;
            });
        }
    },
});
