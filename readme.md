<img src="https://s-media-cache-ak0.pinimg.com/736x/b9/94/e4/b994e4378507f5624aa90ae7778ded86.jpg">

Para arrancar la jornada de trabajo:
1. Hago un checkout de mi master local para posicionarme en él, hago un pull del master remoto para traer los cambios.
2. Hay dos opciones:
    a) Si trabajo siempre en una sola rama: hago un checkout de la rama y hago un merge com mi master local.
    b) Si voy creando ramas por cada funcionalidad: creo una nueva rama a partir del master -> fetch (opcional) -> checkout as new local branch.

Para subir al master:
1. Ejecuto las pruebas.
2. Hago un commit and push de mi rama (sobre la carpeta del proyecto hacer click derecho -> git -> Commit directory)
3. Hago un checkout de mi master local (para posicionarme en el).
4. Hago un pull del master remoto para traer los últimos cambios que hayan hecho (acá pueden aparecer conflictos).
5. Hago un merge con mi rama (acá es muy probable que aparezcan conflictos).
6. Ejecuto las pruebas.
7. Hago un push del master local para que quede remoto.

modico acá.
