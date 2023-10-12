# Secciones  
- [Enrutamiento](#Enrutamiento)  
    - [Administración](#Administración)  
        - [Obtener todos los usuarios](#Obtener-todos-los-usuarios)  
        - [Obtener un unico usuario](#Obtener-un-unico-usuario)  
    - [Juego](#Juego)  
  
# Enrutamiento  
## Administración  
URIs que permiten listar y gestionar uno o varios usuarios dentro del sistema.  
### Obtener todos los usuarios  
- **Metodo**: `GET`  
- **URI**: `localhost:9000/admin/`  
- **Cuerpo de la respuesta**:  
```json  
{    
	"users": [         
		{            
			"userName": "Nava",
			"email": "juannr02@educastillalamancha.edu",
			"gamesPlayed": 31,
			"gamesWinned": 10
		},      
		{            
			"userName": "Asaduji",
			"email": "asaduji1234@outlook.com",
			"gamesPlayed": 25,
			"gamesWinned": 4
		}    
	]  
}    
```
### Obtener un unico usuario  
- **Metodo**: `GET`  
- **URI**:`localhost:9000/admin/2`  
- **Cuerpo de la respuesta**:  
```json
{    
	"email": "any@any.com",   
	"passwordHash": "97ce1f14c5c8113409353b787fb11918978cf56c"
}    
```    
### Crear un nuevo usuario  
- **Metodo**: `POST`  
- **URI**: `localhost:9000/admin/users`  
- **Cuerpo de la peticion**:  
```json  
{
	"userName": "Nava",
	"email": "juannr02@educastillalamancha.edu",
	"password": "1234",
	"isActivated": true
}    
```    

- **Cuerpo de la respuesta**:
> 1 si ya existe una cuenta, 0 si la cuenta ha sido creada correctamente
```json  
{    
	"created": 0
}    
```    
### Modificar un usuario existente  
- **Metodo**: `PUT`  
- **URI**: `localhost:9000/admin/users`  
- **Cuerpo de la peticion**:  
> Editando el nombre de usuario
```json  
{    
	"userName": "NavaF1",
	"email": "juannr02@educastillalamancha.edu"
}    
```
- **Cuerpo de la respuesta**:  
```json  
{    
    "updated": true  
}    
```    
### Desactivar un usuario de la base de datos  
- **Metodo**: `PUT`  
- **URI**: `localhost:9000/admin/users/disable`  
- **Cuerpo de la peticion**:  
```json  
{
	"userName": "NavaF1",
	"email": "juannr02@educastillalamancha.edu",
	"password": "1234"
}    
```    
- **Cuerpo de la respuesta**:  
```json  
{    
    "updated": true  
}    
```    
### Bprrar un usuario definitivamente de la base de datos  
- **Metodo**: `DELETE`  
- **URI**: `localhost:9000/admin/users`  
- **Cuerpo de la peticion**:  
```json  
{    
	"email": "juannr02@educastillalamancha.edu"
}    
```    
- **Cuerpo de la respuesta**  
```json  
{    
	"deleted": true          
}    
```    
### Solicitud de cambio de contraseña  
Se enviará un email con una nueva contraseña a la dirección vinculada a la cuenta.
- **Metodo**: `PUT`  
- **URI**: `localhost:9000/admin/changepassword`  
- **Cuerpo de la peticion**:  
```json  
{
	"email": "juannr02@educastillalamancha.edu"
}    
```    
## Juego  

### Crear una nueva partida estandar  
> Consultar [archivo de constantes](constants.php) para saber valores por defecto.  
- **Metodo**: `POST`  
- **URI**: `localhost:9000/play/create`  
- **Cuerpo de la peticion**:  
```json  
{    
	"userId": 1,    
	"isNewGame": true
}    
```    
- **Respuesta**: 
> '**M**': mina, '**0-2**': pistas, '**\_**': Casilla oculta
```json  
{      
	"game": {        
		"id": 10,        
		"progress": "_1___0_21M",     
		"hidden": "M1M120021M"  
	}
}    
``` 
### Crear una nueva partida personalizada  
> *Ejemplo: Crear partida con **15** casillas y **5** minas*  
  
- **Metodo**: `POST`  
- **URI** -> `localhost:9000/play/create/15/5`  
- **Cuerpo de la peticion**:  
```json  
{    
    "userId": 1,     
    "isNewGame": true  
}    
```    
- **Cuerpo de la respuesta**:  
```json  
{    
    "gameId": 10,      
    "created": true  
}    
```    
### Realizar turno en una partida  
- **Metodo**: `POST`  
- **URI** -> `localhost:9000/play`  
- **Cuerpo de la peticion**:  
```json  
{  
	"userId": 1,    
	"passwordToken": "DSA2312FH",      
	"game": {         
		"position": 2  
	}
}    
```
### Solicitar rendición
- **Metodo**: `PUT`  
- **URI** -> `localhost:9000/play`  
- **Cuerpo de la peticion**:
```json  
{    
    "userId": 1,     
    "gameId": 10,      
    "progress": "_1___0_21M",      
    "hidden": "M1M120021M",      
    "finished": false  
}    
```    
- **Cuerpo de la respuesta**:  
```json  
{    
    "changed": true  
}    
```