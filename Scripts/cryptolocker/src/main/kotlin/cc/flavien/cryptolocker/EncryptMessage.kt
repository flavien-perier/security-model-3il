package cc.flavien.cryptolocker

import java.io.FileOutputStream
import java.security.KeyPair
import java.security.KeyPairGenerator
import java.security.PrivateKey
import java.security.PublicKey
import javax.crypto.Cipher
import java.security.KeyFactory
import java.security.spec.X509EncodedKeySpec
import java.security.spec.PKCS8EncodedKeySpec

class EncryptMessage(
        var publicKey: PublicKey?,
        var privateKey: PrivateKey?
) {
    constructor(): this(null, null) {
        val kp: KeyPair
        val kpg: KeyPairGenerator = KeyPairGenerator.getInstance(CRYPTO_METHOD)
        kpg.initialize(CRYPTO_BITS)
        kp = kpg.genKeyPair()

        publicKey = kp.public
        privateKey = kp.private
    }

    fun encrypt(input: ByteArray): ByteArray {
        val cipher = Cipher.getInstance("RSA")
        cipher.init(Cipher.ENCRYPT_MODE, privateKey)

        return cipher.doFinal(input)
    }

    fun decrypt(input: ByteArray): ByteArray {
        val cipher = Cipher.getInstance("RSA")
        cipher.init(Cipher.DECRYPT_MODE, publicKey)

        return cipher.doFinal(input)
    }

    fun savePair() {
        val outPrivate = FileOutputStream("private_key")
        outPrivate.write(privateKey!!.encoded)
        outPrivate.close()

        val outPublic = FileOutputStream("public_key")
        outPublic.write(publicKey!!.encoded)
        outPublic.close()
    }

    companion object {
        const val CRYPTO_METHOD = "RSA"
        const val CRYPTO_BITS = 1024

        fun getPrivate(keyBytes: ByteArray): PrivateKey {
            val spec = PKCS8EncodedKeySpec(keyBytes)
            val kf = KeyFactory.getInstance(CRYPTO_METHOD)
            return kf.generatePrivate(spec)
        }

        fun getPublic(keyBytes: ByteArray): PublicKey {
            val spec = X509EncodedKeySpec(keyBytes)
            val kf = KeyFactory.getInstance(CRYPTO_METHOD)
            return kf.generatePublic(spec)
        }
    }
}