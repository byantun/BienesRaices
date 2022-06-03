///<references types="cypress"/>

describe ('Probar la Autenctacion', () => {
    it('Probar la Autenticacion en /login', () =>{
        cy.visit('/login');
        cy.get('[data-cy="heading-login"]').should('exist');
        cy.get('[data-cy="heading-login"]').should('have.text', 'Iniciar Sesión');

        cy.get('[data-cy="formulario-login"]').should('exist');

        //Ambos Campos son obligatorios
        cy.get('[data-cy="formulario-login"]').submit();
        cy.get('[data-cy="alerta-login"]').should('exist');
        cy.get('[data-cy="alerta-login"]').eq(0).should('have.class','error');
        cy.get('[data-cy="alerta-login"]').eq(0).should('have.text','El Email es obligatorio');

        cy.get('[data-cy="alerta-login"]').eq(1).should('have.class','error');
        cy.get('[data-cy="alerta-login"]').eq(1).should('have.text','El Password es obligatorio');

        //Usuario Exista
        cy.get('[data-cy="formulario-email"]').type('correo@correo.com');
        //verificar el Password
        cy.get('[data-cy="formulario-password"]').type('123456');
        //Logueo
        cy.get('[data-cy="formulario-login"]').submit();




    })
});