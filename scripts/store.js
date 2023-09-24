import fs from 'fs'

class Store {
  constructor(configFile, defaults = {}) {
    this.path = configFile + '.json'
    this.data = defaults

    try {
      if (fs.existsSync(this.path)) {
        let contents = JSON.parse(fs.readFileSync(this.path, 'utf-8'))
        this.data = { ...defaults, ...contents }
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
