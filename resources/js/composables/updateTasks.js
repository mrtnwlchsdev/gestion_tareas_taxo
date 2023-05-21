const updateTasks = (tasks, description, title, id) => {
    const get_tags = tasks.map((task) => {
        if (task.id === id) {
            task = {
                ...task,
                task_title: title,
                task_description: description,
            };
        }
        return task;
    });

    return get_tags;
};

export default updateTasks;
