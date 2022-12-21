var gulp = require("gulp");
var sftp = require("gulp-sftp");

gulp.task("default", function () {
    return gulp.src("**").pipe(
        sftp({
            host: "ftp.occamy.cz",
            user: "ppi-user",
            pass: "nC&S(W2g$5$kGRv9",
            remotePath: "/home/ppi-user/server",
            exclude: ["vendor", "node_modules"]
        })
    );
});
