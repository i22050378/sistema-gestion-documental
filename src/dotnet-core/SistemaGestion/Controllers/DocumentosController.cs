using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using SistemaGestion.Models;

namespace SistemaGestion.Controllers
{
    public class DocumentosController : Controller
    {
        private readonly AppDbContext _context;
        private readonly IWebHostEnvironment _env;

        public DocumentosController(AppDbContext context, IWebHostEnvironment env)
        {
            _context = context;
            _env = env;
        }

        // Lista de documentos
        public async Task<IActionResult> Index()
        {
            var documentos = await _context.Documentos
                .Include(d => d.Creador)
                .OrderByDescending(d => d.FechaCreacion)
                .ToListAsync();
            return View(documentos);
        }

        // Formulario crear documento
        public IActionResult Crear()
        {
            return View();
        }

        // Guardar documento
        [HttpPost]
        public async Task<IActionResult> Crear(Documento documento, IFormFile archivo)
        {
            if (archivo != null && archivo.Length > 0)
            {
                var uploadsFolder = Path.Combine(_env.WebRootPath, "uploads");
                Directory.CreateDirectory(uploadsFolder);
                var fileName = Guid.NewGuid().ToString() + Path.GetExtension(archivo.FileName);
                var filePath = Path.Combine(uploadsFolder, fileName);

                using (var stream = new FileStream(filePath, FileMode.Create))
                {
                    await archivo.CopyToAsync(stream);
                }

                documento.RutaArchivo = "/uploads/" + fileName;
                documento.TipoArchivo = Path.GetExtension(archivo.FileName).TrimStart('.').ToUpper();
            }

            documento.FechaCreacion = DateTime.Now;
            documento.FechaActualizacion = DateTime.Now;
            documento.IdCreador = 1;

            _context.Documentos.Add(documento);
            await _context.SaveChangesAsync();

            return RedirectToAction("Index");
        }

        // Detalle documento
        public async Task<IActionResult> Detalle(int id)
        {
            var documento = await _context.Documentos
                .Include(d => d.Creador)
                .FirstOrDefaultAsync(d => d.IdDocumento == id);

            if (documento == null) return NotFound();
            return View(documento);
        }

        // Cambiar estado
        [HttpPost]
        public async Task<IActionResult> CambiarEstado(int id, string estado)
        {
            var documento = await _context.Documentos.FindAsync(id);
            if (documento == null) return NotFound();

            documento.Estado = estado;
            documento.FechaActualizacion = DateTime.Now;
            await _context.SaveChangesAsync();

            return RedirectToAction("Detalle", new { id = id });
        }
    }
}