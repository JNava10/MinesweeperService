
# Enrutamiento  
## Juego
URIs que permiten listar y gestionar uno o varios usuarios dentro del sistema.  
### Crear partida por defecto
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/play/create`
- **Cuerpo de la peticion**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```
- **Cuerpo de la respuesta**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```

### Crear partida personalizada
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/play/create/{casillas}/{minas}`
- **Cuerpo de la peticion**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```
- **Cuerpo de la respuesta**:  
```json  
{
    "status": {
        "code": 200,
        "description": "OK"
    },
    "data": {
        "game": {
            "gameId": 11,
            "userId": 2,
            "progress": [
                "-",
                "-",
                "-",
                "-",
                "-",
                "-"
            ],
            "hidden": [
                0,
                1,
                "M",
                "M",
                "M",
                1
            ],
            "finished": false
        }
    }
}
```

### Obtener partidas abiertas de usuario
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/play`
- **Cuerpo de la peticion**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```
- **Cuerpo de la respuesta**:  
```json  
{
    "status": {
        "code": 200,
        "description": "OK"
    },
    "data": {
        "games": [
            // Partidas abiertas
        ]
    }
}
```

### Obtener datos de una partida abierta
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/play/{id}`
- **Cuerpo de la peticion**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```
- **Cuerpo de la respuesta**:  
```json  
{
    "status": {
        "code": 200,
        "description": "OK"
    },
    "data": {
        "game": {
            "gameId": 12,
            "userId": 3,
            "progress": [
                "-",
                "-",
                "-",
                "-",
                "-",
                "-"
            ],
            "hidden": [
                "0",
                "1",
                "M",
                "2",
                "M",
                "1"
            ],
            "finished": 0
        }
    }
}
```

### Destapar casilla de una partida
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/play/{id}`
- **Cuerpo de la peticion**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```
- **Cuerpo de la respuesta**:  
```json  
{
    "status": {
        "code": 200,
        "description": "OK"
    },
    "data": {
        "game": {
        // Datos de la partida
        }
    }
}
```


## Ranking

### Obtener datos del ranking
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/ranking`

- **Cuerpo de la respuesta**:  
```json  
{
    "status": {
        "code": 200,
        "description": "OK"
    },
    "data": [
        {
            "userName": "jaime",
            "gamesPlayed": 2,
            "gamesWinned": 1
        },
        {
            "userName": "fernando",
            "gamesPlayed": 0,
            "gamesWinned": 0
        }
//...
    ]
}
```

## Usuarios
### Obtener datos de todos los usuarios
- **Metodo**: `GET`  
- **URI**: `http://localhost:9090/admin/users`

- **Cuerpo de la respuesta**:  
```json  
[
    {
        "userName": "fernando",
        "email": "any@hotmail.com",
        "password": "12342",
        "gamesPlayed": 0,
        "gamesWinned": 0,
        "role": null,
        "enabled": 0
    },
    {
        "userName": "oscar",
        "email": "any@gmail.com",
        "password": "1234",
        "gamesPlayed": 0,
        "gamesWinned": 0,
        "role": null,
        "enabled": 0
    }
//...
]

```

## Login
### Loguearse con un usuario
**Metodo**: `GET`  
- **URI**: `http://localhost:9090/play/{id}`
- **Cuerpo de la peticion**:  
```json  
{
    "email": "any@hotmail.com",
    "password": 12342
} 
```
- **Cuerpo de la respuesta**:  
```json  
{
    // Datos del usuario
} 
```
