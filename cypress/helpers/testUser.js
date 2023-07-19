function createUser() {
    const username = "tester" + Math.floor(Math.random() * 100);
    const password = "Password" + Math.floor(Math.random() * 100);

    cy.visit("//localhost/signup");
    cy.get("#username").type(username);
    cy.get("#password").type(password);
    cy.get("#cPassword").type(password);
    
    cy.get("#submit").click();  

    return [username, password];
}

function logUserIn(username, password) {
    cy.visit("//localhost/login");
    cy.get("#username").type(username);
    cy.get("#password").type(password);
    cy.get("#login").submit();
}

function deleteUser(username, password) {
    logUserIn(username, password);
    cy.get("#login").submit();  
}

export {createUser, logUserIn, deleteUser};