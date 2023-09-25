const { exec } = require('child_process')

exports.default = async function (context) {
  if (process.platform === 'win32') {
    let command = 'cd ' + context.appOutDir
    command += ' && signtool sign /n "Open Source Developer, Norman Huth"'
    command += ' /t http://time.certum.pl/ /fd sha1 /v "'
    command += context.packager.appInfo.productFilename + '.exe"'
    exec(command, function (error, stdout) {
      if (error) {
        console.error(error)
        process.abort()
      }

      if (stdout.length > 0) {
        console.log(stdout)
      }
    })
  }
}
