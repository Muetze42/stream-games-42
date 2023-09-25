const { exec } = require('child_process')

exports.default = function (data) {
  if (process.platform === 'win32') {
    let artifactPaths = data.artifactPaths.filter((path) => path.endsWith('.exe'))
    let command = 'signtool sign /n "Open Source Developer, Norman Huth"'
    command += ' /t http://time.certum.pl/ /fd sha256 /v '
    command += '"' + artifactPaths[0] + '"'
    exec(command, function (error, stdout) {
      if (error) {
        console.error(error)
      }

      if (stdout.length > 0) {
        console.log(stdout)
      }
    })
  }
}
