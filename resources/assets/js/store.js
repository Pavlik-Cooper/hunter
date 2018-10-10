import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);

const searchTree = (arr,id)=>{
    if (arr) {
        for (var i = 0; i < arr.length; i++) {
            if (arr[i].id == id) {
                return arr[i];
            }
            var found = searchTree(arr[i].replies, id);
            if (found) return found;
        }
    }
};
export const store = new Vuex.Store({
    state: {
        replies: []
    },
    getters: {
        replies: state =>{
            return state.replies;
        },
    },
    mutations: {
        setReplies: (state, payload) => {
            state.replies = payload;
        },
        addReply: (state, data) => {
            if (data.parent_id !== null){
                let parent = searchTree(state.replies,data.parent_id);
                console.log('parent',parent);
                if (parent){
                    let check = parent.replies.filter(item => item.id == data.id);
                    if (check.length == 0){
                        parent.replies.push(data)
                    }
                }
            }else {
                let check = state.replies.filter(item => item.id == data.id);
                if (check.length == 0){
                    state.replies.push(data)
                }
            }
        }

    },
    actions: {
        setReplies: ({commit}, payload) => {
            commit('setReplies',payload);
        },
        addReply: ({commit}, payload) => {
            commit('addReply',payload);
        }
    }

});
