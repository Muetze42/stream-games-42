import path from 'path'
import fs from 'fs'

class Logger {
  constructor(path, environment = '', level = 'error') {
    this.level = level
    this.path = path
    this.environment = environment
  }

  setLevel(level) {
    this.level = level
  }

  setEnvironment(environment) {
    this.environment = environment
  }

  shouldLog(level) {
    const levels = {
      emergency: 8,
      alert: 7,
      critical: 6,
      error: 5,
      warning: 4,
      notice: 3,
      info: 2,
      debug: 1
    }
    const configuredLevel = levels[this.level] ? levels[this.level] : 0
    const wantedLevel = levels[level] ? levels[level] : 999

    return wantedLevel >= configuredLevel
  }

  emergency(message, causer = null) {
    this._write(message, causer, 'emergency')
  }
  alert(message, causer = null) {
    this._write(message, causer, 'alert')
  }
  critical(message, causer = null) {
    this._write(message, causer, 'critical')
  }
  error(message, causer = null) {
    this._write(message, causer, 'error')
  }
  warning(message, causer = null) {
    this._write(message, causer, 'warning')
  }
  notice(message, causer = null) {
    this._write(message, causer, 'notice')
  }
  info(message, causer = null) {
    this._write(message, causer, 'info')
  }
  debug(message, causer = null) {
    this._write(message, causer, 'debug')
  }

  _write(message, causer = null, level = 'error') {
    if (!this.shouldLog(level)) {
      return
    }

    let dateObj = new Date()
    let dateTime = dateObj.toISOString().slice(0, 19).replace('T', ' ')
    let date = dateTime.slice(0, 10)

    if (typeof message !== 'string') {
      message = JSON.stringify(message)
    }

    let data = ''
    let file = path.join(this.path, date + '.log')

    if (fs.existsSync(file)) {
      data = fs.readFileSync(file, 'utf-8').trim()
    }

    if (data && data !== '') {
      data += '\n'
    }
    data += '[' + dateTime + '] ' + this.environment

    if (causer) {
      data += '[' + causer + ']'
    }

    if (this.environment || causer) {
      data += '.'
    }

    data += level + ': ' + message + '\n'

    fs.writeFileSync(file, data)
  }
}

export default Logger
