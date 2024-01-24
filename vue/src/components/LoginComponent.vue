<template>
    <div>
      <h1>Iniciar sesión</h1>
      <label for="loginEmail">Email:</label>
      <input type="text" id="loginEmail" v-model="loginEmail" />
      <label for="loginPassword">Contraseña:</label>
      <input type="password" id="loginPassword" v-model="loginPassword" />
      <button @click="login">Iniciar sesión</button>
      <p v-if="loginSuccessMessage">{{ loginSuccessMessage }}</p>
    </div>
  </template>
  
  <script>

  
  export default {
    data() {
      return {
        loginEmail: "",
        loginPassword: "",
        loginSuccessMessage: "",
      };
    },
    methods: {
      async login() {
        try {
          const response = await fetch("http://localhost:8000/api/login", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              email: this.loginEmail,
              password: this.loginPassword,
            }),
            credentials: "include",
          });
  
          if (!response.ok) {
            throw new Error("Response is not ok");
          }
  
          const data = await response.json();
  
          // Puedes realizar acciones adicionales después de iniciar sesión, si es necesario
  
          this.loginSuccessMessage = "¡Inicio de sesión exitoso!";
        } catch (error) {
          console.error("Error al iniciar sesión:", error);
        }
      },
    },
  };
  </script>
  