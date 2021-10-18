const http = require('http');
const https = require('https');


var redisAdapter = require('socket.io-redis');

var Redis = require('ioredis');

var async = require("async");
var fs = require('fs');
const util = require('util');
const readFile = util.promisify(fs.readFile);

async function createServer () {
	// console.log('Test sdhgsdf',  process.env)
	// const dotenv_filename = await readFile(__dirname+'/../.env', 'utf8');
    // require('dotenv').config(
    //     {
    //         path: __dirname+'/../.env.' + dotenv_filename.trim()
    //     }
    // );

    // console.log('process.env', process.env)

    require('dotenv').config(
        {
            path: __dirname+'/.env'
        }
    );

    var channels = process.env.channels ? process.env.channels.split(',') : [];

    var redis_credentials = {
        host: process.env.REDIS_HOST,
        port: process.env.REDIS_PORT
    }
    if (process.env.REDIS_PASSWORD) {
    	redis_credentials.password = process.env.REDIS_PASSWORD
    }

    console.log('redis_credentials',  redis_credentials)
	var redis = require('redis').createClient(redis_credentials);
	var redisCli =   require('redis').createClient(redis_credentials);

	await redisCli.keys(`active.users.*.*`, async function (err, reply) {

		reply ? reply.map(function (k) {
			redisCli.del(k);
		}) :  null;

	});

	let app = null;

	/**
	 * Create Secure server
	 */

	 if(process.env.IS_SECURE_SERVER == 'yes') {

	 	const options = {
			  key: fs.readFileSync(process.env.NODE_SSL_KEY_PATH),
			  cert: fs.readFileSync(process.env.NODE_SSL_CERT_PATH),
			  rejectUnauthorized  : false,
		};

		app = https.createServer(options, (req, res) => {

		 	const headers = {
			    'Access-Control-Allow-Origin': '*',
			    'Access-Control-Allow-Methods': 'OPTIONS, POST, GET',
			    'Access-Control-Max-Age': 2592000, // 30 days
			    /** add other headers as per requirement */
			  };

			  if (req.method === 'OPTIONS') {
			    res.writeHead(204, headers);
			    res.end();
			    return;
			  }

			  if (['GET', 'POST'].indexOf(req.method) > -1) {
			    res.writeHead(200, headers);
			    res.end('Hello to auntysg chat in https');
			    return;
			  }

			  res.writeHead(405, headers);
			  res.end(`${req.method} is not allowed for the request.`);

		}).listen(process.env.PORT);

	 }
	 else {

		app = http.createServer((req, res) => {

			const headers = {
			    'Access-Control-Allow-Origin': '*',
			    'Access-Control-Allow-Methods': 'OPTIONS, POST, GET',
			    'Access-Control-Max-Age': 2592000, // 30 days
			    /** add other headers as per requirement */
			  };

			  if (req.method === 'OPTIONS') {
			    res.writeHead(204, headers);
			    res.end();
			    return;
			  }

			  if (['GET', 'POST'].indexOf(req.method) > -1) {
			    res.writeHead(200, headers);
			    res.end('Welcome to Auntysg chat');
			    return;
			  }

			  res.writeHead(405, headers);
			  res.end(`${req.method} is not allowed for the request.`);

		}).listen(process.env.PORT);
	}

	var io = require('socket.io')(app);

	io.on('connection', function(socket) {
		onSocketConnection(socket, io, redisCli);
	});

	channels.forEach(function (channel) {
		redis.subscribe(channel, function(err, count) {
			console.log('Channel12 has been subscribed', channel)
		});
	})

	// Redis Event Listner
	redis.on('message', function( channel, message) {
        console.log('Get message test ',channel, message);
	    toBroadcast(io, channel, message , redisCli);
	});

}


createServer();

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}


/**
 * Socket activities
 */
function onSocketConnection(socket, io, redis) {

	socket.on('disconnect', () => {
        console.log('Test Disconnected', socket.id)
		redis.keys(`active.users.*.${socket.id}`, async function (err, reply) {
			reply.map(function (k) {
                console.log('I get the socket it', k)
				io.emit('notification.user_offline', k);
				redis.del(k);
			});
		});
	});

	socket.on('connect', () => {
		io.emit('notification.user_offline',['data']);
        console.log('Test Disconnected', socket.id)
		redis.keys(`active.users.*.${socket.id}`, async function (err, reply) {
			io.emit('notification.user_offline', k);
		});
	});
}

/**
* TO Broadcats the Message
*/
async function toBroadcast(io, channel, data, redis) {

	data = JSON.parse(data);

	io.sockets.emit('newmsg', data);


	var receivers = data.data.to_user;
	console.log("eventttttttttttttttttt",data.event);
	if(data.event == 'App\\Events\\SendSeenStatus1'){
		console.log('socketdnbjesbd??????????',data.event);
		console.log("daatttaaaaaaaa",data.data.data.recieveruser.socket_id);
		var socket_ids = [data.data.data.recieveruser.socket_id];

	}
	else if(data.event == 'App\\Events\\SendMessage'){
		var socket_ids = [data.data.data.recieveruser.socket_id];
	}
	else if(data.event == 'App\\Events\\DeleteChatMessage'){

		console.log("dfghj",socket_ids,data);
		var socket_ids = [data.data.data.recieveruser.socket_id,data.data.data.user.socket_id];
		// var socket_ids = [data.user.socket_id];
	}
	// else if(data.event == 'App\\Events\\DeleteSenderChatMessage'){
	// 	console.log("dfghj",socket_ids,data);
	// 	var socket_ids = [data.data.data.user.socket_id];
	// 	// var socket_ids = [data.user.socket_id];
	// }
	else if(data.event == 'App\\Events\\SendDeliverStatus'){
		var socket_ids = [data.data.data.recieveruser.socket_id];
	}

	else{
	var socket_ids = data.data.socket_ids;
	}
	console.log("sockeetttttttt iiiiiddddd",socket_ids);
	// var socket_ids = ['ImYiM-V5BSeFmNXOAAAD'];

	// When broadcast only the specific socket ids
	if(socket_ids) {

		console.log("socket idddddddddddddddddddddd",socket_ids);

		socket_ids.map(function (si) {
			io.to(`${si}`).emit(`${channel}.${data.event}`, data);
		})
	}
	else {

	console.log("to User frefrjfb,bf,bfjbf,",data.event);
		console.log("hellloooooooo",socket_ids);
		// When Need to find the socket the by the user_id
		receivers.map(async function (user_id) {

			// var user_id  = user.receiver_id;
            socket_ids =  await getUserSocketId(user_id, redis);
            console.log('get Socket ID ', socket_ids, user_id)
			socket_ids.map(function (si) {
                console.log('Testsydghsfdhsfdhgdf', socket_ids, `${channel}.${data.event}`)
				io.to(`${si}`).emit(`${channel}.${data.event}`, data);
			})
		})
	}

}

async function getUserSocketId(user_id, redis) {

	var ids = await new Promise (async function (res, rej) {

		await redis.keys(`active.users.${user_id}.*`, async function (err, reply) {

			if(!reply) {
				var ids = [];
				res(ids);
				return;
			}
			var socket_ids = reply.map(function (key) {
				var key_arry = key.split('.');
				var socket_id = key_arry[3];
				var user_id = key_arry[2];
				return socket_id;
			});
			res(socket_ids);
			// return ids;
		});

	});
	return ids;
}
