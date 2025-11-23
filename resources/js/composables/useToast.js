import ToastEventBus from 'primevue/toasteventbus';

export const useToast = () => {
    const add = (params) => {
        ToastEventBus.emit('add', params);
    }

    return { add };
};
