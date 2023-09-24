import fs from 'fs'

function merge(obj, src) {
  Object.keys(src).forEach(function(key) {
    if (typeof src[key] === 'object') {
      if (typeof obj[key] === 'undefined') obj[key] = {}
      obj[key] = merge(obj[key], src[key])
    } else {
      obj[key] = src[key]
    }
  })

  return obj
}

class Store {
  constructor(configFile, defaults = {}) {
    this.path = configFile + '.json'
    this.data = defaults

    try {
      if (fs.existsSync(this.path)) {
        let contents = JSON.parse(fs.readFileSync(this.path, 'utf-8'))
        // this.data = { ...defaults, ...contents }
        this.data = merge(defaults, contents)
      }
    } catch (e) {
      this.data = defaults
    }
  }

  getData() {
    return this.data
  }

  setData(data) {
    if (typeof data === 'string') {
      data = JSON.parse(data)
    }

    this.data = data
  }

  storeData() {
    fs.writeFileSync(this.path, JSON.stringify(this.data))
  }
}

export default Store
