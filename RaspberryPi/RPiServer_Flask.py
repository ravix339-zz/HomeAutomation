from flask import Flask, request
import sqlite3

conn = sqlite3.connect('homeautomation.db')
app = Flask(__name___)

def writeToMotor(SQLRow):
    return True

@app.route("/")
def homePage():
    return "Hello"
@app.route("/SetBlinds")
def setBlinds():
    if not (request.args.get('BlindName') or request.args.get('PercentOpen')):
        raise ValueError('Arguments not provided')
    c = conn.cursor()
    ret = ""
    for row in c.execute("SELECT * FROM BlindControl WHERE blindName LIKE '?%'",(request.args.get('BlindName'),) ):
        c.execute("UPDATE BlindControl SET requested = 1")
        
@app.route("/<ip_address>")
def pingMotor(ip_address):
    c = conn.cursor()
    result = c.execute("SELECT * FROM BlindControl WHERE ipaddress = ?", ip_address)
    if result[-1] == 0:
        return ""
    else:
        return result[4]-result[3]
        c.execute("UPDATE BlindControl prev=expected, requested=0")

    
    

