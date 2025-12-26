</main>

<!-- Epic Footer -->
<footer class="gradient-bg mt-auto">
    <div class="container mx-auto px-6 py-16 text-center">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <!-- Brand -->
            <div>
                <h2 class="text-4xl font-black text-white mb-4">BLOG<span class="text-yellow-300">FIRE</span></h2>
                <p class="text-gray-300">Where ideas ignite and stories come alive.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Explore</h3>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="index.php" class="hover:text-yellow-300 transition">Home</a></li>
                    <li><a href="#" class="hover:text-yellow-300 transition">About</a></li>
                    <li><a href="#" class="hover:text-yellow-300 transition">Contact</a></li>
                    <li><a href="#" class="hover:text-yellow-300 transition">Privacy</a></li>
                </ul>
            </div>

            <!-- Admin -->
            <div>
                <h3 class="text-xl font-bold text-white mb-4">Control Center</h3>
                <?php if (isAdmin()): ?>
                    <a href="admin/" class="block bg-white/20 glass px-6 py-3 rounded-lg text-white hover:bg-white/30 transition text-center">
                        Go to Admin Panel
                    </a>
                <?php endif; ?>
            </div>

            <!-- Copyright -->
            <div class="text-center md:text-right">
                <p class="text-gray-400 text-sm">
                    © 2025 BLOGFIRE — Made with <span class="text-red-500">Heart</span> & PHP
                </p>
                <div class="mt-4 flex justify-center md:justify-end space-x-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full animate-pulse"></div>
                    <div class="w-10 h-10 bg-yellow-400 rounded-full animate-pulse delay-75"></div>
                    <div class="w-10 h-10 bg-purple-400 rounded-full animate-pulse delay-150"></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('avatarPreview').src = reader.result;
    };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>