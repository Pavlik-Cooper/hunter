let user = window.App.user;

module.exports = {

update(model,foreign_key = 'user_id'){
    return model[foreign_key] === user.id;
}

};