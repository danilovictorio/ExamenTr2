<template>
    <div>

      <h1>Registrate</h1>
      <label for="name">Nombre de usuario</label>
      <input type="text" id="name" v-model="name" />
      <label for="name">Email:</label>
      <input type="text" id="email" v-model="email" />
      <label for="password">Contraseña</label>
      <input type="password" id="password" v-model="password" />
      <button @click="registerUser">Registrarse</button>

    </div>
    
  </template>
  <script>

  
  export default {
    data() {
      return {
   nombre:
      };
    },
    methods: {
        async crearArchivo() {
        try {
          const response = await fetch("http://localhost:8000/login", {
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

  
          this.loginSuccessMessage = "¡Inicio de sesión exitoso!";
        } catch (error) {
          console.error("Error al iniciar sesión:", error);
        }
      },
      

      
      
    }
    
  </script>
  